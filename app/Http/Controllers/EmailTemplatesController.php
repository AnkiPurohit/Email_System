<?php

namespace App\Http\Controllers;


use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\EmailTemplateCreateRequest;
use App\Http\Requests\EmailTemplateUpdateRequest;
use App\Repositories\EmailTemplateRepository;
use App\Validators\EmailTemplateValidator;
use Illuminate\Support\Facades\Session;

/**
 * Class EmailTemplatesController.
 *
 * @package namespace App\Http\Controllers;
 */
class EmailTemplatesController extends Controller
{
    /**
     * @var EmailTemplateRepository
     */
    protected $repository;

    /**
     * @var EmailTemplateValidator
     */
    protected $validator;

    /**
     * EmailTemplatesController constructor.
     *
     * @param EmailTemplateRepository $repository
     * @param EmailTemplateValidator $validator
     */
    public function __construct(EmailTemplateRepository $repository, EmailTemplateValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $emailTemplates = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $emailTemplates,
            ]);
        }

        return view('emailTemplates.index', compact('emailTemplates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EmailTemplateCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(EmailTemplateCreateRequest $request)
    {
        try {

            $emailTemplate = $this->repository->create($request->all());

            $response = [
                'message' => 'EmailTemplate created.',
                'data'    => $emailTemplate->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }
            Session::flash('message', $response['message']);
            return redirect()->route('dashboard');
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('emailTemplates.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $emailTemplate = $this->repository->find($id);

        if (request()->wantsJson()) {
            return response()->json([
                'data' => $emailTemplate,
            ]);
        }

        return view('emailTemplates.show', compact('emailTemplate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $emailTemplate = $this->repository->find($id);

        return view('emailTemplates.edit', compact('emailTemplate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EmailTemplateUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(EmailTemplateUpdateRequest $request)
    {
        try {

            $emailTemplate = $this->repository->update($request->all(), $request->input('id'));

            $response = [
                'message' => 'EmailTemplate updated.',
                'data'    => $emailTemplate->toArray(),
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            Session::flash('message', $response['message']);
            return redirect()->route('dashboard');
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'EmailTemplate deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'EmailTemplate deleted.');
    }
}
