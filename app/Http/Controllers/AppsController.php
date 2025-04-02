<?php

namespace App\Http\Controllers;

use App\Actions\UpsertAppAction;
use App\DataTransferObject\AppData;
use App\Http\Requests\UpsertAppRequest;
use App\Http\Resources\AppResource;
use App\Models\App;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AppsController extends Controller
{

    public function __construct(
        public readonly UpsertAppAction $upsertAppAction
    )
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index():AnonymousResourceCollection
    {
        $user = Auth::user();
        return AppResource::collection(App::where('user_id', $user->id)->get());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request):JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'url' => ['required', 'url', Rule::unique("apps", 'url')],
            'name' => ['required', 'string', 'max:255', Rule::unique("apps", 'name')],
            'org' => 'required|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'There is issue with your payload. '.implode(',',$validator->errors()->all()), 'error'=>$validator->errors()]);
        }

        $mka=App::create([
            "name" =>$input['name'],
            "url" =>$input['url'],
            "user_id" =>Auth::id(),
            "private_link" => "pl".Auth::id().Str::random(),
            "public_link" => Auth::id().Str::random(),
        ]);
        return AppResource::make($mka)
        ->response()
        ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(App $app)
    {
        return new AppResource($app);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpsertAppRequest $request, App $app):JsonResponse
    {
        $user = Auth::user();
        if($app->user_id != $user->id){
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        $mka=$this->upsert($request, $app);
        return AppResource::make($mka)
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function upsert(
        UpsertAppRequest $request,
        App $app
    )
    {
        $appData = new AppData(...$request->validated());
        return $this->upsertAppAction::execute($appData, $app);
    }
}
