@extends('operator.layout')
@section('title', 'Task Update')

@section('content')

<div class="w-full max-w-7xl space-y-6">

    {{-- HEADER --}}
    <div class="bg-white rounded-[25px] p-8 border border-green-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4">

        <div class="flex items-center gap-5">

            <div class="p-4 bg-green-100 rounded-2xl">
                <i data-lucide="clipboard-list" class="w-10 h-10 text-green-600"></i>
            </div>

            <div>
                <h1 class="text-3xl font-black text-[#1F4D1F]">
                    Task Update
                </h1>

                <p class="text-slate-500">
                    Complete waste collection and maintenance tasks.
                </p>
            </div>

        </div>

        <div class="px-6 py-2 border-2 border-[#1F4D1F] rounded-full font-bold text-[#1F4D1F]">

            {{ $tasks->count() }} Available Task

        </div>

    </div>

    {{-- LIST TASK --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        @forelse($tasks as $task)

        <div class="bg-white rounded-3xl border border-green-100 shadow-sm p-6">

            {{-- STATUS --}}
            <div class="flex justify-between items-center mb-5">

                @if($task->sensor_error)

                    <span class="px-4 py-2 rounded-full bg-red-100 text-red-600 text-xs font-bold uppercase">

                        Maintenance

                    </span>

                @else

                    <span class="px-4 py-2 rounded-full bg-orange-100 text-orange-600 text-xs font-bold uppercase">

                        Bin Full

                    </span>

                @endif

                <div class="flex items-center gap-2">

                    <span class="text-sm font-semibold text-slate-500">
                        Task Status :
                    </span>

                    @if($task->task_status == 'pending')

                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                            Pending
                        </span>

                    @elseif($task->task_status == 'in_progress')

                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                            In Progress
                        </span>

                    @else

                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                            Completed
                        </span>

                    @endif

                </div>

            </div>

            {{-- BIN --}}
            <div class="flex items-center gap-4">

                <div class="p-3 bg-green-50 rounded-xl">

                    <i data-lucide="trash-2" class="w-7 h-7 text-green-600"></i>

                </div>

                <div>

                    <h2 class="text-lg font-bold text-slate-800">

                        {{ $task->name }}

                    </h2>

                    <p class="text-sm text-slate-500">

                        {{ $task->homebase->name ?? '-' }}

                    </p>

                </div>

            </div>

            {{-- DETAIL --}}
            <div class="mt-6 space-y-3">

                <div class="flex justify-between">

                    <span class="text-slate-500">

                        Capacity

                    </span>

                    <span class="font-bold">

                        {{ $task->capacity }}%

                    </span>

                </div>

                <div class="flex justify-between">

                    <span class="text-slate-500">

                        Last Update

                    </span>

                    <span class="font-bold">

                        {{ $task->updated_at?->diffForHumans() }}

                    </span>

                </div>

            </div>

            {{-- BUTTON --}}
            <div class="mt-8">

                @if($task->task_status == 'pending')

                    <button
                        onclick="startTask('{{ $task->_id }}')"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl">

                        Start Task

                    </button>

                @elseif($task->task_status == 'in_progress')

                    <button
                        onclick="completeTask('{{ $task->_id }}')"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl">

                        Complete Task

                    </button>

                @else

                    <button
                        disabled
                        class="w-full bg-green-100 text-green-700 font-bold py-3 rounded-xl">

                        ✓ Task Completed

                    </button>

                @endif

            </div>

        </div>

        @empty

        <div class="col-span-full">

            <div class="bg-white rounded-3xl border-2 border-dashed border-slate-200 p-16 text-center">

                <i data-lucide="clipboard-check" class="w-14 h-14 mx-auto text-slate-300 mb-4"></i>

                <h3 class="text-xl font-bold text-slate-600">

                    No Pending Task

                </h3>

                <p class="text-slate-400 mt-2">

                    All tasks have been completed.

                </p>

            </div>

        </div>

        @endforelse

    </div>

</div>

<script>

function startTask(id){

    fetch('/operator/taskupdate/'+id+'/start',{

        method:'POST',

        headers:{
            'X-CSRF-TOKEN':'{{ csrf_token() }}',
            'Accept':'application/json'
        }

    })
    .then(response=>response.json())
    .then(data=>{

        if(data.success){

            location.reload();

        }

    });

}

function completeTask(id){

    fetch('/operator/taskupdate/'+id+'/complete',{

        method:'POST',

        headers:{
            'X-CSRF-TOKEN':'{{ csrf_token() }}',
            'Accept':'application/json'
        }

    })
    .then(response=>response.json())
    .then(data=>{

        if(data.success){

            location.reload();

        }

    });

}

</script>

@endsection