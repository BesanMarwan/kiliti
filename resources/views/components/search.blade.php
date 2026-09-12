@props(['searchable'=>[],'checkboxes'=>[]])
<div class="card shadow-sm mb-3">
    <div class="card-header h-50px collapsible cursor-pointer rotate collapsed" data-bs-toggle="collapse"
         data-bs-target="#kt_docs_card_collapsible">
        <h3 class="card-title">@lng('dashboard.general.search','بحث')</h3>
        <div class="card-toolbar rotate-180">
          <span class="svg-icon svg-icon-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)"
                      fill="currentColor"></rect>
                <path
                    d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z"
                    fill="currentColor"></path>
            </svg>
        </span>
        </div>
    </div>
    <form action="{{URL::current()}}" method="get" class="form-horizontal mb-0 gen-search-class">
        <div id="kt_docs_card_collapsible" class="collapse">
            <div class="card-body p-3">

                <div class="d-flex flex-wrap justify-content-start gap-3">
                    @foreach($searchable as $id=>$item)
                        @if(in_array($item['type'],['number','string','date']))
                            <x-input-search name="{{$id}}" type="{{$item['type']}}" :value="request($id)"
                                            :placeholder="$item['title']"/>
                        @elseif($item['type'] == 'select')
                            @if(isset($item['options']))
                                <x-select-search name="{{$id}}" :value="request($id)" :placeholder="$item['title']"
                                                 :options="$item['options']"/>
                            @elseif(isset($item['model']))
                                @php
                                    $searchobj = new ('App\\Models\\'.$item['model']);
                                    $search_items=$searchobj->get();
                                @endphp
                                <x-select-search name="{{$id}}" :value="request($id)" :placeholder="$item['title']"
                                                 :options="$search_items"/>
                            @elseif(isset($item['model_class']))
                                @php
                                    $searchobj = new ($item['model_class']);
                                    if(isset($item['model_query'])){
                                        $search_items=$searchobj->where($item['model_query'])->get();

                                    }else{
                                        $search_items=$searchobj->get();
                                    }

                                @endphp
                                <x-select-search name="{{$id}}" :value="request($id)" :placeholder="$item['title']"
                                                 :options="$search_items"/>
                            @endif

                        @elseif($item['type'] == 'range')
                            <x-input-search name="{{$id.'_from'}}" type="{{str_contains($id,'date')||str_contains($id,'created_')?'date':'text'}}"  :value="request($id.'_from')"
                                            :placeholder="$item['title'] .' '.lng('dashboard.search.from','من')"/>
                            <x-input-search name="{{$id.'_to'}}" type="{{str_contains($id,'date')||str_contains($id,'created_')?'date':'text'}}"  :value="request($id.'_to')"
                                            :placeholder="$item['title'] .' '.lng('dashboard.search.to','الى')"/>
                        @endif
                        @php
                            if($item['type'] == 'checkbox'){
                                $checkboxes[$id]=$item;
                            }
                        @endphp
                    @endforeach


                </div>

            </div>
            <div class="card-footer p-2 d-flex justify-content-between">
                <div>
                    <div class="d-flex flex-wrap gap-3 h-100">
                        @foreach($checkboxes as $id=>$item)

                            <x-inputs.checkbox name="{{$id}}" :checked="request($id)?true:false" value="1"
                                               :title="$item['title']"/>

                        @endforeach


                    </div>
                </div>
                <div>
                    <button type="reset"
                            data-form-class="gen-search-class"
                            class="btn btn-sm btn-flex btn-light-warning w-150px align-items-center clear-btn justify-content-center mx-1 my-1">
                        <i class="la la-redo la-lg"></i>
                        @lng('dashboard.general.clear','تفريغ')
                    </button>
                    <button type="submit"
                            data-form-class="gen-search-class"
                            class="btn btn-sm btn-flex btn-light-info w-150px align-items-center search-btn justify-content-center mx-1 my-1">
                        <i class="la la-search la-lg"></i>
                        @lng('dashboard.general.search','بحث')
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>
