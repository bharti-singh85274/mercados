<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>

    <div>
         @if(session()->has('success'))
            <div style="color: green; text-align: center;padding-top: 10px;">
                {{session()->get('success')}}
            </div>
            @endif 
    </div>
   
     <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="post" action="{{url('add-post')}}">
                        @csrf
                        <div class="mb-3">
                             <x-label for="title" :value="__('Title')" />
                            <x-input id="title" class="block mt-1 w-1/2" type="text" name="title" />
                          <span style="color: red;">
                            @error('title') {{ $message ?? '' }} @enderror
                            </span> 

                        </div>
                        <div class="mb-3">
                             <x-label for="description" :value="__('Description')" />
                            <textarea class="block mt-1 w-1/2" name="description"  rows="3"></textarea>
                             <span style="color: red;">
                            @error('description') {{ $message ?? '' }} @enderror
                            </span>  
                        </div>
                       
                   <x-button class="ml-3">
                    {{ __('Submit') }}
                     </x-button>

                      <a href="{{url('view')}}">View All</a>

                    </form>

                    <br>

                </div>
            </div>
        </div>
    </div>
           
</x-app-layout>


