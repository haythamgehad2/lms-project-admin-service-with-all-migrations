<?php

namespace App\Listeners;
use App\Events\MissionProgressEvent;
use App\Models\MissionProgressDetails;
use App\Models\RewardAction;
class CreateMissionProgressListener
{
    /**
     * Create the event listener.
     */
    public function __construct(protected RewardAction $rewardAction,protected MissionProgressDetails $missionProgressDetails){}
    /**
     * Handle the event.
     */
    public function handle(MissionProgressEvent $event): void
    {

        $videos=$event->mission->videosBanks()->wherePivot('is_selected',true)->count();
        $paperWorks=$event->mission->papersWork()->wherePivot('is_selected',true)->count();
        $quizzes=$event->mission->quizzes()->wherePivot('is_selected',true)->count();

        $rewardActionVideos= $this->rewardAction->whereIn("action_unique_name" ,[RewardAction::start_video,RewardAction::complete_video])->selectRaw('SUM(jeel_coins) as jeel_coins, SUM(jeel_xp) as jeel_xp')->first();
        $rewardActionPaperWork = $this->rewardAction->whereIn("action_unique_name" ,[RewardAction::paper_work_upload,RewardAction::paper_work_download])->selectRaw('SUM(jeel_coins) as jeel_coins, SUM(jeel_xp) as jeel_xp')->first();
        $rewardActionQuiz = $this->rewardAction->whereIn("action_unique_name" ,[RewardAction::finish_exam])->selectRaw('SUM(jeel_coins) as jeel_coins, SUM(jeel_xp) as jeel_xp')->first();

        foreach($event->mission->learningPaths->pluck('id') as $learningPathId)
        {

          $videosLearningPathCount= $event->mission->videosBanks()->wherePivot('is_selected',true)->wherePivot('learning_path_id',$learningPathId)->count();
          $participatoryPaperWorksLearningPathCount= $event->mission->papersWork()->where('type','participatory')->wherePivot('is_selected',true)->wherePivot('learning_path_id',$learningPathId)->count();
          $singlePaperWorksLearningPathCount= $event->mission->papersWork()->where('type','single')->wherePivot('is_selected',true)->wherePivot('learning_path_id',$learningPathId)->count();
          $quizzesLearningPathCount= $event->mission->quizzes()->wherePivot('is_selected',true)->wherePivot('learning_path_id',$learningPathId)->count();

             /**
             * Calc Mission Progress Total Xp , Total Jeel Coins On LearningPath and Videos , and etc
             */
             $missionProgress=$this->missionProgressDetails->updateOrCreate([
                'mission_id'=>$event->mission->id,
                'learning_path_id'=>$learningPathId,
                ],[
                'mission_id'=>$event->mission->id,
                'learning_path_id'=>$learningPathId,
                'total_path_jc'=>($videosLearningPathCount*$rewardActionVideos->jeel_coins)+(($singlePaperWorksLearningPathCount+$participatoryPaperWorksLearningPathCount)*$rewardActionPaperWork->jeel_coins)+($quizzesLearningPathCount*$rewardActionQuiz->jeel_coins),
                'total_path_xp'=>($videosLearningPathCount*$rewardActionVideos->jeel_xp)+(($singlePaperWorksLearningPathCount+$participatoryPaperWorksLearningPathCount)*$rewardActionPaperWork->jeel_xp)+($quizzesLearningPathCount*$rewardActionQuiz->jeel_xp),
                'total_videos_xp'=>($videosLearningPathCount*$rewardActionVideos->jeel_xp),
                'total_videos_jc'=>($videosLearningPathCount*$rewardActionVideos->jeel_coins),
                'total_single_paper_works_xp'=>($singlePaperWorksLearningPathCount*$rewardActionPaperWork->jeel_xp),
                'total_single_paper_works_jc'=>($singlePaperWorksLearningPathCount*$rewardActionPaperWork->jeel_coins),
                'total_participatory_paper_works_xp'=>($participatoryPaperWorksLearningPathCount*$rewardActionPaperWork->jeel_xp),
                'total_participatory_paper_works_jc'=>($participatoryPaperWorksLearningPathCount*$rewardActionPaperWork->jeel_coins),
                'total_quizzes_jc'=>($quizzesLearningPathCount*$rewardActionQuiz->jeel_coins),
                'total_quizzes_xp'=>($quizzesLearningPathCount*$rewardActionQuiz->jeel_xp),
            ]);

            /**
             * Calc Mission LearningPath Total Xp , Total Jeel Coins
             */
             $event->mission->learningPaths()->updateExistingPivot(
             $learningPathId,['total_xp'=>($videosLearningPathCount*$rewardActionVideos->jeel_xp)+(($singlePaperWorksLearningPathCount+$participatoryPaperWorksLearningPathCount)*$rewardActionPaperWork->jeel_xp)+($quizzesLearningPathCount*$rewardActionQuiz->jeel_xp)
            ,'total_jc'=>($videosLearningPathCount*$rewardActionVideos->jeel_coins)+(($singlePaperWorksLearningPathCount+$participatoryPaperWorksLearningPathCount)*$rewardActionPaperWork->jeel_coins)+($quizzesLearningPathCount*$rewardActionQuiz->jeel_coins),
            ]);

        }
        /**
         * Calc Mission Total Xp , Total Jeel Coins
         */
      $event->mission->update(['total_xp'=>($videos*$rewardActionVideos->jeel_xp)+($paperWorks*$rewardActionPaperWork->jeel_xp)+($quizzes*$rewardActionQuiz->jeel_xp),
       'total_jc'=>($videos*$rewardActionVideos->jeel_coins)+($paperWorks*$rewardActionPaperWork->jeel_coins)+($quizzes*$rewardActionQuiz->jeel_coins)
       ]);

    }
}
