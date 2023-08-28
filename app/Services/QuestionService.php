<?php
namespace App\Services;
use App\Helpers\ReturnData;
use App\Http\Resources\Question\QuestionFullDetailsResource;
use App\Http\Resources\Question\QuestionResource;
use App\Http\Resources\Question\QuestionsResource;
use App\Mapper\PaginationMapper;
use App\Models\QuestionAnswer;
use App\Models\QuestionType;
use App\Repositories\QuestionAnswerRepository;
use App\Repositories\QuestionDifficultyRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\QuestionTypeRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
class QuestionService
{


    /**
     * _Construction function
     *
     * @param QuestionRepository $questionRepository
     * @param PaginationMapper $paginationMapper
     * @param ReturnData $returnData
     */
    public function __construct(protected QuestionRepository $questionRepository,
    protected QuestionTypeRepository $questionTypeRepository,
    protected QuestionAnswerRepository $questionAnswerRepository
    ,protected QuestionDifficultyRepository $questionDifficultyRepository
    ,protected PaginationMapper $paginationMapper,protected ReturnData $returnData){}


    /**
     * Get All function
     *
     * @param array $options
     * @return array
     */
    public function getAll(array $options = [])
    {
        $quesitons = $this->questionRepository->getAll($options);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            QuestionsResource::collection($quesitons),
            __('admin.questions.list'),
            $quesitons instanceof \Illuminate\Pagination\LengthAwarePaginator ?
            $this->paginationMapper->metaPagination($options,$quesitons):[]
        );

    }


    /**
    * Show function
    *
    * @param array $options
    * @return array
    */
    public function show(int $id)
    {
        $term = $this->questionRepository->show($id);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new QuestionResource($term),
            [__('admin.questions.show')],
        );
    }

    /**
     * @param array $options
     * @return array
    */
    public function fullDetails(int $id): array
    {
        $term = $this->questionRepository->show($id);

        return $this->returnData->create(
            [],
            Response::HTTP_OK,
            new QuestionFullDetailsResource($term),
            [__('admin.questions.show')],
        );
    }


    /**
     * Matching Function function
     *
     * @param [type] $answers
     * @param [type] $question
     * @return void
     */
    private function questionMatchType($answers,$question){
        foreach($answers as $answerfrom){

            $answerfrom['question_id']=$question->id;

            if($question['question_pattern']== 'image'){
                $questionAnswerFrom= QuestionAnswer::create(Arr::except($answerfrom, ['answer']));

                if(isset($answerfrom['answer'])){
                    $questionAnswerFrom->saveFiles($answerfrom['answer']);
                }
            }else{
                $questionAnswerFrom= QuestionAnswer::create($answerfrom);
            }


            if (isset($answerfrom['audio'])){
                $questionAnswerFrom->updateAudio($answerfrom['audio'],'audio/answer',$questionAnswerFrom,'answer_audio');
            }
            $matchTo=[];

            foreach($answerfrom['answers_to'] as $answerTo){
                $answerTo['question_id']=$question->id;
                $answerTo['correct_answers']=json_encode(array($questionAnswerFrom->id));

                if($question['question_pattern']== 'image'){
                    $questionAnswerTo= QuestionAnswer::create(Arr::except($answerTo, ['answer']));

                    if(isset($answerTo['answer'])){
                        $questionAnswerTo->saveFiles($answerTo['answer']);
                    }
                }else{
                    $questionAnswerTo= QuestionAnswer::create($answerTo);
                }

                array_push($matchTo,$questionAnswerTo->id);

                if (isset($answerTo['audio'])){
                    $questionAnswerTo->updateAudio($answerTo['audio'],'audio/answer',$questionAnswerTo,'answer_audio');
                }
            }
            $questionAnswerFrom->update(['correct_answers'=>$matchTo]);
        }
    }

    /**
     * Drag And Drop function
     *
     * @param [type] $answers
     * @param [type] $question
     * @return void
     */
    private function questionDragAndDrop($answers,$question){
            foreach($answers as $answer){
                $answer['question_id']=$question->id;


                if($question['question_pattern']== 'image'){
                    $questionAnswer= QuestionAnswer::create(Arr::except($answer, ['answer']));

                    if(isset($answer['answer'])){
                        $questionAnswer->saveFiles($answer['answer']);
                    }
                }else{
                    $questionAnswer= QuestionAnswer::create($answer);
                }

                if (isset($answer['audio'])){
                    $questionAnswer->updateAudio($answer['audio'],'audio/answer',$questionAnswer,'answer_audio');
            }
        }
    }


    /**
     * Question True And False function
     *
     * @param [type] $answers
     * @param [type] $question
     * @return void
     */
    private function questionTrueAndFalse($answers,$question){
            foreach($answers as $answer){
                $answer['question_id']=$question->id;

                 if($question['question_pattern']== 'image'){
                    $questionAnswer= QuestionAnswer::create(Arr::except($answer, ['answer']));

                    if(isset($answer['answer'])){
                        $questionAnswer->saveFiles($answer['answer']);
                    }
                }else{
                    $questionAnswer= QuestionAnswer::create($answer);
                }


                if (isset($answer['audio'])){
                    $questionAnswer->updateAudio($answer['audio'],'audio/answer',$questionAnswer,'answer_audio');
                }
        }
    }

    /**
     * MCQ function
     *
     * @param [type] $answers
     * @param [type] $question
     * @return void
     */
    private function questionMcQAndSelectAnswers($answers,$question){

            foreach($answers as $answer){
                $answer['question_id']=$question->id;

                if($question['question_pattern']== 'image'){
                    $questionAnswer= QuestionAnswer::create(Arr::except($answer, ['answer']));

                    if(isset($answer['answer'])){
                        $questionAnswer->saveFiles($answer['answer']);
                    }
                }else{
                    $questionAnswer= QuestionAnswer::create($answer);
                }


                if (isset($answer['audio'])){
                    $questionAnswer->updateAudio($answer['audio'],'audio/answer',$questionAnswer,'answer_audio');
                }

        }

    }


    /**
     * Create function
     *
     * @param array $data
     * @return array
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $question_type = $this->questionTypeRepository->find($data['question_type_id'],['slug']);
            $question_type_sub = $this->questionTypeRepository->find($data['question_type_sub_id'],['slug']);

            $question = $this->questionRepository->create($data);

            if (isset($data['question_audio'])){
                $question->uplodeAudio($data['question_audio'],'audio/questions',$question,'question_audio');
            }


            /** Question Answers */
            if($question_type->slug =='mcq' || $question_type->slug =='select' || $question_type_sub->slug =='drag_and_drop_one') {
                $this->questionMcQAndSelectAnswers($data['answers'],$question);

            }elseif($question_type->slug =='true_false'){
                $this->questionTrueAndFalse($data['answers'],$question);

            }
            elseif($question_type->slug =='match'){
                $this->questionMatchType($data['answers'],$question);
            }
            elseif($question_type->slug =='drag_and_drop' || $question_type_sub->slug =='drag_and_drop_many' ){
                $this->questionDragAndDrop($data['answers'],$question);
            }



            if(isset($data['quiz_id']))
            {
                $question->quizzes()->sync([$data['quiz_id']]);
            }

            DB::commit();
                return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new QuestionResource($question),
                    [__('admin.questions.create')]
                );

        }catch (Exception $excption) {
            logger(
                [
                    'error' =>$excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            DB::rollback();

            return $this->returnData->create(
                [__('admin.questions.not_create')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }

    }

    /**
     * Update function
     *
     * @param array $data
     * @param integer $id
     * @return array
     */
    public function update(array $data, int $id)
    {
        DB::beginTransaction();

        try {

            $question_type = $this->questionTypeRepository->find($data['question_type_id'],['slug']);
            $question_type_sub = $this->questionTypeRepository->find($data['question_type_sub_id'],['slug']);

            $question=$this->questionRepository->update($data, $id);

            if (isset($data['question_audio'])){
                $question->updateAudio($data['question_audio'],'audio/questions',$question,'question_audio');
            }

            $this->questionAnswerRepository->deleteAnswers($id);

               /** Question Answers */
               if($question_type->slug =='mcq' || $question_type->slug =='select' || $question_type_sub->slug =='drag_and_drop_one') {
                $this->questionMcQAndSelectAnswers($data['answers'],$question);

                }elseif($question_type->slug =='true_false'){
                    $this->questionTrueAndFalse($data['answers'],$question);

                }
                elseif($question_type->slug =='match'){
                    $this->questionMatchType($data['answers'],$question);
                }
                elseif($question_type->slug =='drag_and_drop' || $question_type_sub->slug =='drag_and_drop_many' ){
                    $this->questionDragAndDrop($data['answers'],$question);
                }


            DB::commit();
            return $this->returnData->create(
                    [],
                    Response::HTTP_OK,
                    new QuestionResource($question),
                    [__('admin.questions.update')]
                );

            }catch (Exception $excption) {
                logger(
                    [
                        'error'=> $excption->getMessage(),
                        'code' => $excption->getCode(),
                        'file' => $excption->getFile(),
                        'line' => $excption->getLine(),
                    ]
                );
            DB::rollback();

            return $this->returnData->create(
                [__('admin.questions.not_update')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }

    }

    /**
     * Delete function
     *
     * @param integer $id
     * @return array
     */
    public function delete(int $id)
    {
        try {
            $this->questionRepository->delete($id);
            return $this->returnData->create(
                [],
                Response::HTTP_OK,
                [],
                [__('admin.questions.delete')]
            );
        } catch (Exception $excption) {
            logger(
                [
                    'error' => $excption->getMessage(),
                    'code' => $excption->getCode(),
                    'file' => $excption->getFile(),
                    'line' => $excption->getLine(),
                ]
            );

            return $this->returnData->create(
                [__('admin.questions.not_delete')],
                Response::HTTP_UNPROCESSABLE_ENTITY,
                []
            );
        }
    }
}
