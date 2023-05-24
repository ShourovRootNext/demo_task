@extends('admin::layouts.content')

@section('page_title')
    {{ __('velocity::app.admin.meta-data.title') }}
@stop

@php
    $locale = request()->get('locale') ?: app()->getLocale();
    $channel = request()->get('channel') ?: core()->getCurrentChannelCode();
@endphp

@section('content')
    <div class="content">
        <form
            method="POST"
            @submit.prevent="onSubmit"
            enctype="multipart/form-data"
            @if ($metaData)
                action="{{ route('velocity.admin.store.meta-data', ['id' => $metaData->id]) }}"
            @else
                action="{{ route('velocity.admin.store.meta-data', ['id' => 'new']) }}"
            @endif
            >

            @csrf

            <div class="page-header force-responsive-breakable">
                <div class="page-title">
                    <h1>{{ __('velocity::app.admin.meta-data.title') }}</h1>
                </div>
                <div class="page-action">
                    <div class="action-list">
                        <input type="hidden" name="locale" value="{{ $locale }}" />
                        <input type="hidden" name="channel" value="{{ $channel }}" />

                        <div class="control-group">
                            <select class="control" id="channel-switcher" onChange="window.location.href = this.value">
                                @foreach (core()->getAllChannels() as $ch)

                                    <option value="{{ route('velocity.admin.meta-data') . '?channel=' . $ch->code . '&locale=' . $locale }}" {{ ($ch->code) == $channel ? 'selected' : '' }}>
                                        {{ $ch->name }}
                                    </option>

                                @endforeach
                            </select>
                        </div>

                        <div class="control-group">
                            <select class="control" id="locale-switcher" onChange="window.location.href = this.value">
                                @foreach (core()->getAllLocales() as $localeModel)

                                    <option value="{{ route('velocity.admin.meta-data') . '?locale=' . $localeModel->code . '&channel=' . $channel }}" {{ ($localeModel->code) == $locale ? 'selected' : '' }}>
                                        {{ $localeModel->name }}
                                    </option>

                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-lg btn-primary action_last_btn">
                            {{ __('velocity::app.admin.meta-data.update-meta-data') }}
                        </button>
                    </div>
                </div>
            </div>

            <accordian :title="'{{ __('velocity::app.admin.meta-data.general') }}'" :active="true">
                <div slot="header">{{ __('velocity::app.admin.meta-data.general') }}</div>
                <div slot="body">
                    <div class="control-group" style="display:none">
                        <label>{{ __('velocity::app.admin.meta-data.activate-slider') }}</label>

                        <label class="switch">
                            <input
                                id="slides"
                                name="slides"
                                type="checkbox"
                                class="control"
                                data-vv-as="&quot;slides&quot;"
                                value="{{ $metaData && $metaData->slider}}"
                                {{ $metaData && $metaData->slider ? 'checked' : ''}} />

                            <span class="slider round"></span>
                        </label>
 
                    </div>

                    <div class="control-group">
                        <label>{{ __('velocity::app.admin.meta-data.sidebar-categories') }}</label>

                        <input
                            type="number"
                            min="0"
                            class="control"
                            id="sidebar_category_count"
                            name="sidebar_category_count"
                            value="{{ $metaData ? $metaData->sidebar_category_count : '10' }}" />
                    </div>

                    <div class="control-group">
                        <label>{{ __('velocity::app.admin.meta-data.header_content_count') }}</label>

                        <input
                            type="number"
                            min="0"
                            class="control"
                            id="header_content_count"
                            name="header_content_count"
                            value="{{ $metaData ? $metaData->header_content_count : '5' }}" />
                    </div>

                    <?php
                            //dd($metaData);
                    ?>

                    <div class="control-group" style="display:none">
                        <label>{{ __('shop::app.home.featured-products') }}</label>

                        <input
                            type="number"
                            min="0"
                            class="control"
                            id="featured_product_count"
                            name="featured_product_count"
                            value="{{ $metaData ? $metaData->featured_product_count : 10 }}" />
                    </div>

                    <div class="control-group" style="display:none">
                        <label>{{ __('shop::app.home.new-products') }}</label>

                        <input
                            type="number"
                            min="0"
                            class="control"
                            id="new_products_count"
                            name="new_products_count"
                            value="{{ $metaData ? $metaData->new_products_count : 10 }}" />
                    </div>

                  

 
                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.home-page-content') }}
                            <span class="locale">[{{ $metaData ? $metaData->channel : $channel }} - {{ $metaData ? $metaData->locale : $locale }}]</span>
                        </label>

                        <textarea
                            class="control"
                            id="home_page_content"
                            name="home_page_content">
                            {{ $metaData ? $metaData->home_page_content : '' }}
                        </textarea>
                    </div>

                    <div class="control-group">
                        <label style="width:100%;">
                            {{ __('velocity::app.admin.meta-data.product-policy') }}
                            <span class="locale">[{{ $metaData ? $metaData->channel : $channel }} - {{ $metaData ? $metaData->locale : $locale }}]</span>
                        </label>

                        <textarea
                            class="control"
                            id="product-policy"
                            name="product_policy">
                            {{ $metaData ? $metaData->product_policy : '' }}
                        </textarea>
                    </div>

                </div>
            </accordian>
  

            <accordian :title="'{{ __('velocity::app.admin.meta-data.home-page-features') }}'" :active="true" style="display:none">
                <div slot="header">{{ __('velocity::app.admin.meta-data.home-page-features') }}</div>
                <div slot="body" style="display:grid;grid-template-columns:35% auto;">
                    <div class="control-group">
                        <label>{{ __('velocity::app.admin.meta-data.home.product-policy') }}</label>

                        <label class="switch">
                            <input
                                id="slides"
                                name="slides"
                                type="checkbox"
                                class="control"
                                data-vv-as="&quot;slides&quot;"
                                {{ $metaData && $metaData->slider ? 'checked' : ''}} />

                            <span class="slider round"></span>
                        </label>
                    </div>

                    <div class="control-group">
                        <label>{{ __('velocity::app.admin.meta-data.home.advertisement-four') }}</label>

                        <label class="switch">
                            <input
                                id="slides"
                                name="slides"
                                type="checkbox"
                                class="control"
                                data-vv-as="&quot;slides&quot;"
                                {{ $metaData && $metaData->slider ? 'checked' : ''}} />

                            <span class="slider round"></span>
                        </label>
                    </div>


                    <div class="control-group">
                        <label>{{ __('velocity::app.admin.meta-data.home.popular-categories') }}</label>

                        <label class="switch">
                            <input
                                id="slides"
                                name="slides"
                                type="checkbox"
                                class="control"
                                data-vv-as="&quot;slides&quot;"
                                {{ $metaData && $metaData->slider ? 'checked' : ''}} />

                            <span class="slider round"></span>
                        </label>
                    </div>

                    <div class="control-group">
                        <label>{{ __('velocity::app.admin.meta-data.home.advertisement-three') }}</label>

                        <label class="switch">
                            <input
                                id="slides"
                                name="slides"
                                type="checkbox"
                                class="control"
                                data-vv-as="&quot;slides&quot;"
                                {{ $metaData && $metaData->slider ? 'checked' : ''}} />

                            <span class="slider round"></span>
                        </label>
                    </div>


                    
                    <div class="control-group">
                        <label>{{ __('velocity::app.admin.meta-data.home.featured-products') }}</label>

                        <label class="switch">
                            <input
                                id="slides"
                                name="slides"
                                type="checkbox"
                                class="control"
                                data-vv-as="&quot;slides&quot;"
                                {{ $metaData && $metaData->slider ? 'checked' : ''}} />

                            <span class="slider round"></span>
                        </label>
                    </div>




                    <div class="control-group">
                        <label>{{ __('velocity::app.admin.meta-data.home.advertisement-two') }}</label>

                        <label class="switch">
                            <input
                                id="slides"
                                name="slides"
                                type="checkbox"
                                class="control"
                                data-vv-as="&quot;slides&quot;"
                                {{ $metaData && $metaData->slider ? 'checked' : ''}} />

                            <span class="slider round"></span>
                        </label>
                    </div>




                    <div class="control-group">
                        <label>{{ __('velocity::app.admin.meta-data.home.top-selling-products') }}</label>

                        <label class="switch">
                            <input
                                id="slides"
                                name="slides"
                                type="checkbox"
                                class="control"
                                data-vv-as="&quot;slides&quot;"
                                {{ $metaData && $metaData->slider ? 'checked' : ''}} />

                            <span class="slider round"></span>
                        </label>
                    </div>




                    <div class="control-group">
                        <label>{{ __('velocity::app.admin.meta-data.home.new-products') }}</label>

                        <label class="switch">
                            <input
                                id="slides"
                                name="slides"
                                type="checkbox"
                                class="control"
                                data-vv-as="&quot;slides&quot;"
                                {{ $metaData && $metaData->slider ? 'checked' : ''}} />

                            <span class="slider round"></span>
                        </label>
                    </div>



                    <div class="control-group">
                        <label>{{ __('velocity::app.admin.meta-data.home.advertisement-one') }}</label>

                        <label class="switch">
                            <input
                                id="slides"
                                name="slides"
                                type="checkbox"
                                class="control"
                                data-vv-as="&quot;slides&quot;"
                                {{ $metaData && $metaData->slider ? 'checked' : ''}} />

                            <span class="slider round"></span>
                        </label>
                    </div>


                    


                    <div class="control-group">
                        <label>{{ __('velocity::app.admin.meta-data.home.category-products') }}</label>

                        <label class="switch">
                            <input
                                id="slides"
                                name="slides"
                                type="checkbox"
                                class="control"
                                data-vv-as="&quot;slides&quot;"
                                {{ $metaData && $metaData->slider ? 'checked' : ''}} />

                            <span class="slider round"></span>
                        </label>
                    </div>
                    


                    <div class="control-group">
                        <label>{{ __('velocity::app.admin.meta-data.home.recent-products') }}</label>

                        <label class="switch">
                            <input
                                id="slides"
                                name="slides"
                                type="checkbox"
                                class="control"
                                data-vv-as="&quot;slides&quot;"
                                {{ $metaData && $metaData->slider ? 'checked' : ''}} />

                            <span class="slider round"></span>
                        </label>
                    </div>


                    


                </div>
            </accordian>

            <accordian :title="'{{ __('velocity::app.admin.meta-data.images') }}'" :active="false">
                <div slot="header">{{ __('velocity::app.admin.meta-data.images') }}</div>
                <div slot="body">
                    <div class="control-group">
                        <label>{{ __('velocity::app.admin.meta-data.advertisement-four') }}</label>

                        @php
                            $images = [
                                4 => [],
                                3 => [],
                                2 => [],
                            ];

                            $index = 0;

                            foreach ($metaData->get('locale')->all() as $key => $value) {
                                if ($value->locale == $locale) {
                                    $index = $key;
                                }
                            }

                            $advertisement = json_decode($metaData->get('advertisement')->all()[$index]->advertisement, true);
                        //    dd($advertisement);
                        @endphp

                        @if(! isset($advertisement[4]) || ! count($advertisement[4]))
                            @php
                                $images[4][] = [
                                    'id' => 'image_1',
                                    'url' => asset('/themes/aretha-franklin/assets/images/banner/apic-1-1.jpg'),
                                ];
                                $images[4][] = [
                                    'id' => 'image_2',
                                    'url' => asset('/themes/aretha-franklin/assets/images/banner/apic-1-2.jpg'),
                                ];
                                $images[4][] = [
                                    'id' => 'image_3',
                                    'url' => asset('/themes/aretha-franklin/assets/images/banner/apic-1-3.jpg'),
                                ];
                                $images[4][] = [
                                    'id' => 'image_4',
                                    'url' => asset('/themes/aretha-franklin/assets/images/banner/apic-1-2.jpg'),
                                ];
                            @endphp
                        
                            <advertisement-wrapper
                                :multiple="true"
                                input-name="images[4]"
                                link-name="links[4]"
                                :images='@json($images[4])'
                                :button-label="'{{ __('velocity::app.admin.meta-data.add-image-btn-title') }}'">
                            </advertisement-wrapper>
                        @else
                            {{-- {{ dd($advertisement[4]) }} --}}
                            @foreach ($advertisement[4] as $index => $image)
                                @php
                                    $links = "";                                  
                                 
                                    if(str_contains($index,'links_')){
                                        continue;
                                    }
                                    $links = 'links_' . $index;
                                    $images[4][] = [
                                        'id' => 'image_' . $index,
                                        'url' => asset('/storage/' . $image),
                                        'links' => isset($advertisement[4][$links])?$advertisement[4][$links]:'',
                                    ];
                                   
                                @endphp
                            @endforeach
                            <advertisement-wrapper 
                                :multiple="true" 
                                :images="{{ json_encode($images[4]) }}" 
                                input-name="images[4]" 
                                link-name="links[4]" 
                                button-label="{{ __('velocity::app.admin.meta-data.add-image-btn-title') }}">
                            </advertisement-wrapper>
                            {{-- <advertisement-wrapper
                                :multiple="true"
                                input-name="images[4]"
                                link-name="links[4]"
                                :images='@json($images[4])'
                                :button-label="'{{ __('velocity::app.admin.meta-data.add-image-btn-title') }}'">
                            </advertisement-wrapper> --}}
                        @endif
                    </div>

                    <div class="control-group">
                        <label>{{ __('velocity::app.admin.meta-data.advertisement-three') }}</label>
                        @if(! isset($advertisement[3]) || ! count($advertisement[3]))
                            @php
                                $images[3][] = [
                                    'id' => 'image_1',
                                    'url' => asset('/themes/aretha-franklin/assets/images/banner/apic-2-1.jpg'),
                                ];
                                $images[3][] = [
                                    'id' => 'image_2',
                                    'url' => asset('/themes/aretha-franklin/assets/images/banner/apic-2-2.jpg'),
                                ];
                                $images[3][] = [
                                    'id' => 'image_3',
                                    'url' => asset('/themes/aretha-franklin/assets/images/banner/apic-2-3.jpg'),
                                ];
                            @endphp

                            <advertisement-wrapper
                                input-name="images[3]"
                                link-name="links[3]"
                                :images='@json($images[3])'
                                :button-label="'{{ __('velocity::app.admin.meta-data.add-image-btn-title') }}'">
                            </advertisement-wrapper>
                        @else
                            @foreach ($advertisement[3] as $index => $image)
                                @php
                                    $links = "";
                                    if(str_contains($index,'links_')){
                                        continue;
                                    }
                                    $links = 'links_' . $index;
                                    $images[3][] = [
                                        'id' => 'image_' . $index,
                                        'url' => asset('/storage/' . $image),
                                        'links' => isset($advertisement[3][$links])?$advertisement[3][$links]:'',
                                    ];
                                @endphp
                            @endforeach

                            <advertisement-wrapper
                                input-name="images[3]"
                                link-name="links[3]"
                                :images='@json($images[3])'
                                :button-label="'{{ __('velocity::app.admin.meta-data.add-image-btn-title') }}'">
                            </advertisement-wrapper>
                        @endif
                    </div>

                    <div class="control-group">
                        <label>{{ __('velocity::app.admin.meta-data.advertisement-two') }}</label>

                        @if(! isset($advertisement[2]) || ! count($advertisement[2]))
                            @php
                                $images[2][] = [
                                    'id' => 'image_1',
                                    'url' => asset('/themes/aretha-franklin/assets/images/banner/apic-3-1.jpg'),
                                ];
                                $images[2][] = [
                                    'id' => 'image_2',
                                    'url' => asset('/themes/aretha-franklin/assets/images/banner/apic-3-2.jpg'),
                                ];
                                $images[2][] = [
                                    'id' => 'image_3',
                                    'url' => asset('/themes/aretha-franklin/assets/images/banner/apic-3-3.jpg'),
                                ];
                            @endphp

                            <advertisement-wrapper
                                input-name="images[2]"
                                link-name="links[2]"
                                :images='@json($images[2])'
                                :button-label="'{{ __('velocity::app.admin.meta-data.add-image-btn-title') }}'">
                            </advertisement-wrapper>
                        @else
                            @foreach ($advertisement[2] as $index => $image)
                                @php

                                    $links = "";
                                    if(str_contains($index,'links_')){
                                        continue;
                                    }
                                    $links = 'links_' . $index;
                                    $images[2][] = [
                                        'id' => 'image_' . $index,
                                        'url' => asset('/storage/' . $image),
                                        'links' => isset($advertisement[2][$links])?$advertisement[2][$links]:'',
                                    ];
                                @endphp
                            @endforeach

                            <advertisement-wrapper
                                input-name="images[2]"
                                link-name="links[2]"
                                :images='@json($images[2])'
                                :button-label="'{{ __('velocity::app.admin.meta-data.add-image-btn-title') }}'">
                            </advertisement-wrapper>
                        @endif
                    </div>

                    <div class="control-group">
                        <label>{{ __('velocity::app.admin.meta-data.advertisement-one') }}</label>

                        @if(! isset($advertisement[1]) || ! count($advertisement[1]))
                            @php
                                $images[1][] = [
                                    'id' => 'image_1',
                                    'url' => asset('/themes/aretha-franklin/assets/images/banner/apic-3-1.jpg'),
                                ];
                               
                            @endphp

                            <advertisement-wrapper
                                input-name="images[1]"
                                link-name="links[1]"
                                :images='@json($images[1])'
                                :button-label="'{{ __('velocity::app.admin.meta-data.add-image-btn-title') }}'">
                            </advertisement-wrapper>
                        @else
                            @foreach ($advertisement[1] as $index => $image)
                                @php

                                    $links = "";
                                    if(str_contains($index,'links_')){
                                        continue;
                                    }
                                    $links = 'links_' . $index;
                                    $images[1][] = [
                                        'id' => 'image_' . $index,
                                        'url' => asset('/storage/' . $image),
                                        'links' => isset($advertisement[1][$links])?$advertisement[1][$links]:'',
                                    ];
                                @endphp
                            @endforeach

                            <advertisement-wrapper
                                input-name="images[1]"
                                link-name="links[1]"
                                :images='@json($images[1])'
                                :button-label="'{{ __('velocity::app.admin.meta-data.add-image-btn-title') }}'">
                            </advertisement-wrapper>
                        @endif
                    </div>

                </div>
            </accordian>

            
        </form>
    </div>
@stop

@push('scripts')
    <script type="text/x-template" id="advertisement-wrapper-template">
        <div>
            <div class="adv-wrapper">
                <advertisement-item
                    v-for='(image, index) in items'
                    :key='image.id'
                    :image="image"
                    :input-name="inputName"
                    :link-name="linkName"
                    :required="required"
                    :remove-button-label="removeButtonLabel"
                    @onRemoveImage="removeImage($event)"
                ></advertisement-item>
            </div>    
            <button type="button" class="btn btn-lg btn-primary" @click="createFileType">@{{ buttonLabel }}</button>
        </div>
    </script>

    <script type="text/x-template" id="advertisement-item-template">
        <label class="adv-item" :for="_uid" v-bind:class="{ 'has-image': imageData.length > 0 }">
            <input type="hidden" :name="finalInputName"/>    
            <input type="file" v-validate="'mimes:image/*'" accept="image/*" :name="finalInputName" ref="imageInput" :id="_uid" @change="addImageView($event)" :required="required ? true : false" />    
            <img class="preview" :src="imageData" v-if="imageData.length > 0">
            <img class="preview" src="data:image/png;base64,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" v-if="!imageData.length">
            <label class="remove-image" @click="removeImage()">@{{ removeButtonLabel }}</label>
            <div class="control-group">
                <input type="text" class="control" :name="finalLinkName" :value="imageLink" placeholder="http://">
            </div>
        </label>
    </script>
    
    <script type="text/x-template" id="advertisement-upload-template">
        <div class="adv-image">
            <slot></slot>    
            <div class="preview-wrapper">
                <img class="image-preview" :src="sample"/>
            </div>    
            <div class="remove-preview">
                <button class="btn btn-md btn-primary" @click.prevent="removePreviewImage">Remove Image</button>
            </div>    
        </div>
    </script>
    <script>
        Vue.component('advertisement-wrapper', {
            template: '#advertisement-wrapper-template',
            props: {
                buttonLabel: {
                    type: String,
                    required: false,
                    default: 'Add Image'
                },

                removeButtonLabel: {
                    type: String,
                    required: false,
                    default: 'Remove Image'
                },

                inputName: {
                    type: String,
                    required: false,
                    default: 'attachments'
                },

                linkName: {
                    type: String,
                    required: false,
                },

                images: {
                    type: Array|String,
                    required: false,
                    default: () => ([])
                },

                multiple: {
                    type: Boolean,
                    required: false,
                    default: true
                },

                required: {
                    type: Boolean,
                    required: false,
                    default: false
                }
            },

            data: function() {
                return {
                    imageCount: 0,
                    items: []
                }
            },

            created () {
                var this_this = this;

                if(this.multiple) {
                    if (this.images.length) {
                        this.images.forEach(function(image) {
                            this_this.items.push(image)

                            this_this.imageCount++;
                        });
                    } else if (this.images.length == undefined && typeof this.images == 'object') {
                        var images = Object.keys(this.images).map(key => { 
                            return this.images[key]; 
                        }); 

                        images.forEach(function(image) {
                            this_this.items.push(image)

                            this_this.imageCount++;
                        });
                    } else {
                        this.createFileType();
                    }
                } else {
                    if(this.images && this.images != '') {
                        this.items.push({'id': 'image_' + this.imageCount, 'url': this.images})

                        this.imageCount++;
                    } else {
                        this.createFileType();
                    }
                }
            },

            methods: {
                createFileType () {
                    var this_this = this;

                    if(!this.multiple) {
                        this.items.forEach(function(image) {
                            this_this.removeImage(image)
                        });
                    }

                    this.imageCount++;

                    this.items.push({'id': 'image_' + this.imageCount});
                },

                removeImage (image) {
                    let index = this.items.indexOf(image)

                    Vue.delete(this.items, index);
                }
            }
        })

        Vue.component('advertisement-item', {
            template: '#advertisement-item-template',
            props: {
                inputName: {
                    type: String,
                    required: false,
                    default: 'attachments'
                },

                linkName: {
                    type: String,
                    required: false,
                },

                removeButtonLabel: {
                    type: String,
                },

                image: {
                    type: Object,
                    required: false,
                    default: null
                },

                required: {
                    type: Boolean,
                    required: false,
                    default: false
                }
            },

            data: function() {
                return {
                    imageData: '',
                    imageLink: '',
                }
            },

            mounted () {
                // console.log('image :', this.image);
                if(this.image.id && this.image.url) {
                    this.imageData = this.image.url;
                    this.imageLink = this.image.links;
                }
            },

            computed: {
                finalInputName () {
                    return this.inputName + '[' + this.image.id + ']';
                },
                finalLinkName () {
                    return this.linkName + '[' + this.image.id + ']';
                }
            },

            methods: {
                addImageView () {
                    var imageInput = this.$refs.imageInput;
                    // console.log("imageInput",imageInput.files[0]);

                    if (imageInput.files && imageInput.files[0]) {
                        if(imageInput.files[0].type.includes('image/')) {
                            var reader = new FileReader();

                            reader.onload = (e) => {
                                this.imageData = e.target.result;
                                // console.log("this.imageData", this.imageData);
                            }

                            reader.readAsDataURL(imageInput.files[0]);
                        } else {
                            imageInput.value = "";
                            alert('Only images (.jpeg, .jpg, .png, ..) are allowed.');
                        }
                    }
                },

                removeImage () {
                    this.$emit('onRemoveImage', this.image)
                }
            }
        })

        Vue.component('advertisement-upload', {
            template: '#advertisement-upload-template',
            data: function() {
                return {
                    sample: "",
                    image_file: "",
                    file: null,
                    newImage:"",
                };
            },

            mounted: function() {

                this.sample = "";

                var element = this.$el.getElementsByTagName("input")[0];

                var this_this = this;

                element.onchange = function() {
                    var fReader = new FileReader();

                    fReader.readAsDataURL(element.files[0]);

                    fReader.onload = function(event) {
                        this.img = document.getElementsByTagName("input")[0];

                        this.img.src = event.target.result;

                        this_this.newImage = this.img.src;

                        this_this.changePreview();
                    };
                }
            },

            methods: {
                removePreviewImage: function() {
                    this.sample = "";
                },

                changePreview: function(){
                    this.sample = this.newImage;
                }
            },

            computed: {
                getInputImage() {
                    console.log(this.imageData);
                    console.log(this.imageLink);
                }
            }
        })
    </script>

    <script src="{{ asset('vendor/webkul/admin/assets/js/tinyMCE/tinymce.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            tinymce.init({
                height: 200,
                width: "100%",
                image_advtab: true,
                valid_elements : '*[*]',
                selector: 'textarea#home_page_content,textarea#footer_left_content,textarea#subscription_bar_content,textarea#footer_middle_content,textarea#product-policy',
                plugins: 'image imagetools media wordcount save fullscreen code',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | code',
            });
        });
    </script>
@endpush
