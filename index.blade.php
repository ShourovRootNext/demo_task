@extends('admin::layouts.content')

@section('page_title')
    {{ __('velocity::app.admin.customization.title') }}
@stop

@inject ('dragAndDropRepository', 'BuyNoir\DragAndDrop\Repositories\DragAndDropRepository')

@php
    
    $themeDragAndDropData = $dragAndDropRepository
        ->where('company_id', company()->getCurrent()->id)
        ->get()
        ->toArray();   
    $sectionPositions = json_decode($themeDragAndDropData[0]['sectionPositions'] ?? '[]', true);
    $hiddenSections = json_decode($themeDragAndDropData[0]['hiddenSections'] ?? '[]', true);
        
@endphp

@push('scripts')
<script>
    // Load the saved section positions and hidden sections from local storage
    window.addEventListener('DOMContentLoaded', () => {
      const sectionsContainer = document.querySelector('.swap_section');
      
      const sections = Array.from(sectionsContainer.children);

      // Retrieve the section positions from local storage
      const savedPositions = JSON.parse(localStorage.getItem('sectionPositions'));

      if (savedPositions) {
        // Sort the sections based on the saved positions
        sections.sort((a, b) => {
          const orderA = parseInt(savedPositions[a.id]);
          const orderB = parseInt(savedPositions[b.id]);
          return orderA - orderB;
        });

        // Update the DOM with the sorted sections
        sections.forEach((section) => {
          sectionsContainer.appendChild(section);
        });
      }

      // Hide sections that were marked for hiding
      const hiddenSections = JSON.parse(localStorage.getItem('hiddenSections'));

      if (hiddenSections) {
        hiddenSections.forEach((sectionId) => {
          const section = document.getElementById(sectionId);
          if (section) {
            section.style.display = 'none';
          }
        });
      }
    });

    // Save the section positions and hidden sections to local storage
    window.addEventListener('beforeunload', () => {
      const sections = document.querySelectorAll('.section');
      const sectionPositions = {};
      const hiddenSections = [];

      sections.forEach((section, index) => {
        sectionPositions[section.id] = (index + 1).toString();
        if (section.style.display === 'none') {
          hiddenSections.push(section.id);
        }
      });

      localStorage.setItem('sectionPositions', JSON.stringify(sectionPositions));
      localStorage.setItem('hiddenSections', JSON.stringify(hiddenSections));
    });
</script>
@endpush




{{-- {{ dd($themeDragAndDropData[0], $sectionPositions, $hiddenSections) }} --}}
@section('content')
    <div class="content">

        <form method="POST" action="{{ route('admin.draganddrop.customizationstore') }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.home.index') }}';"></i>

                        {{ __('velocity::app.admin.customization.title') }} 
                    </h1>
                </div>

                <div class="page-action">
                    {{-- <button type="submit" class="btn btn-lg btn-warning">
                        Reset
                    </button> --}}
                    <button type="submit" class="btn btn-lg btn-primary" onclick="onSubmit()">
                      {{ __('admin::app.settings.themes.save-btn-title') }}
                  </button>
                </div>
            </div>

            <div class="page-content">
                <div class="form-container">
                    @csrf()
                    <input name="_method" type="hidden" value="PUT">

                    <accordian :title="'{{ __('velocity::app.admin.meta-data.customization') }}'" :active="true">
                        <div slot="header" style="display: flex; justify-content: space-between">
                          <div style="display: flex; align-items: center;">
                            {{ __('velocity::app.admin.meta-data.customization') }}
                          </div>
                          <a class="btn btn-md btn-primary" href="{{ url('/admin/velocity/meta-data') }}">{{ __('velocity::app.admin.customization.advertisement') }}</a>                          
                        </div>
                            <div class="swap_section" slot="body">
                                <div id="section1" class="section" draggable="true" ondragstart="drag(event)" ondragover="allowDrop(event)" ondrop="drop(event)" order="1">
                                    <span class="close-button" onclick="hideSection('section1')">x</span>
                                    <div class="section-background" style="background-image: url('{{ asset('admin-themes/buynoir-admin/assets/admin/assets/images/shop_customization/next-1.jpg') }}');">
                                      <h2>Advertisement First</h2>
                                    </div>                                    
                                </div>
                                <div id="section2" class="section" draggable="true" ondragstart="drag(event)" ondragover="allowDrop(event)" ondrop="drop(event)" order="2">
                                    <span class="close-button" onclick="hideSection('section2')">x</span>
                                    <div class="section-background" style="background-image: url('{{ asset('admin-themes/buynoir-admin/assets/admin/assets/images/shop_customization/next-5.jpg') }}');">
                                      <h2>Featured Products</h2>
                                    </div>
                                </div>
                                <div id="section3" class="section" draggable="true" ondragstart="drag(event)" ondragover="allowDrop(event)" ondrop="drop(event)" order="3">
                                    <span class="close-button" onclick="hideSection('section3')">x</span>
                                    <div class="section-background" style="background-image: url('{{ asset('admin-themes/buynoir-admin/assets/admin/assets/images/shop_customization/next-2.jpg') }}');">
                                      <h2>Advertisement Second</h2>
                                    </div>
                                </div>
                                <div id="section4" class="section" draggable="true" ondragstart="drag(event)" ondragover="allowDrop(event)" ondrop="drop(event)" order="4">
                                    <span class="close-button" onclick="hideSection('section4')">x</span>
                                    <div class="section-background" style="background-image: url('{{ asset('admin-themes/buynoir-admin/assets/admin/assets/images/shop_customization/next-6.jpg') }}');">
                                      <h2>New Products</h2>
                                    </div>
                                </div>
                                <div id="section5" class="section" draggable="true" ondragstart="drag(event)" ondragover="allowDrop(event)" ondrop="drop(event)" order="5">
                                    <span class="close-button" onclick="hideSection('section5')">x</span>
                                    <div class="section-background" style="background-image: url('{{ asset('admin-themes/buynoir-admin/assets/admin/assets/images/shop_customization/next-3.jpg') }}');">
                                      <h2>Advertisement Third</h2>
                                    </div>
                                </div> 
                                <div id="section6" class="section" draggable="true" ondragstart="drag(event)" ondragover="allowDrop(event)" ondrop="drop(event)" order="6">
                                    <span class="close-button" onclick="hideSection('section6')">x</span>
                                    <div class="section-background" style="background-image: url('{{ asset('admin-themes/buynoir-admin/assets/admin/assets/images/shop_customization/next-7.jpg') }}');">
                                      <h2>Recently Viewed Products</h2>
                                    </div>
                                </div> 
                                <div id="section7" class="section" draggable="true" ondragstart="drag(event)" ondragover="allowDrop(event)" ondrop="drop(event)" order="7">
                                    <span class="close-button" onclick="hideSection('section7')">x</span>
                                    <div class="section-background" style="background-image: url('{{ asset('admin-themes/buynoir-admin/assets/admin/assets/images/shop_customization/next-4.jpg') }}');">
                                      <h2>Advertisement Fourth</h2>
                                    </div>
                                </div>                          
                            </div>
                        </div>
                    </accordian>
                </div>
            </div>
        </form>
    </div>
@stop

@push('scripts')
<script>
    // Load the saved section positions and hidden sections from local storage
    window.addEventListener('DOMContentLoaded', () => {
      const sectionsContainer = document.querySelector('.swap_section');
      
      const sections = Array.from(sectionsContainer.children);

      // Retrieve the section positions from local storage
      const savedPositions = JSON.parse(localStorage.getItem('sectionPositions'));

      if (savedPositions) {
        // Sort the sections based on the saved positions
        sections.sort((a, b) => {
          const orderA = parseInt(savedPositions[a.id]);
          const orderB = parseInt(savedPositions[b.id]);
          return orderA - orderB;
        });

        // Update the DOM with the sorted sections
        sections.forEach((section) => {
          sectionsContainer.appendChild(section);
        });
      }

      // Hide sections that were marked for hiding
      const hiddenSections = JSON.parse(localStorage.getItem('hiddenSections'));

      if (hiddenSections) {
        hiddenSections.forEach((sectionId) => {
          const section = document.getElementById(sectionId);
          if (section) {
            section.style.display = 'none';
          }
        });
      }
    });

    function allowDrop(event) {
      event.preventDefault();
    }

    function drag(event) {
      event.dataTransfer.setData('text', event.target.id);
    }

    function drop(event) {
      event.preventDefault();
      const data = event.dataTransfer.getData('text');
      const draggedSection = document.getElementById(data);
      const targetSection = event.target.closest('.section');

      // Swap the order of the dragged section and the target section
      const draggedOrder = draggedSection.getAttribute('order');
      const targetOrder = targetSection.getAttribute('order');
      draggedSection.setAttribute('order', targetOrder);
      targetSection.setAttribute('order', draggedOrder);

      // Reorder the sections based on the updated order attribute
      const sectionsContainer = draggedSection.parentNode;
      const sections = Array.from(sectionsContainer.children);

      // Sort the sections based on the order attribute
      sections.sort((a, b) => {
        const orderA = parseInt(a.getAttribute('order'));
        const orderB = parseInt(b.getAttribute('order'));
        return orderA - orderB;
      });

      // Update the DOM with the new section order
      sections.forEach((section) => {
        sectionsContainer.appendChild(section);
      });

      // Save the updated section positions to local storage
      const sectionPositions = {};
      sections.forEach((section, index) => {
        sectionPositions[section.id] = (index + 1).toString();
      });
      localStorage.setItem('sectionPositions', JSON.stringify(sectionPositions));
    }

    function hideSection(sectionId) {
      const section = document.getElementById(sectionId);
      if (section) {
        section.style.display = 'none';

        // Save the hidden section in local storage
        let hiddenSections = JSON.parse(localStorage.getItem('hiddenSections'));
        if (!hiddenSections) {
          hiddenSections = [];
        }
        hiddenSections.push(sectionId);
        localStorage.setItem('hiddenSections', JSON.stringify(hiddenSections));
      }
    }

    // Add event listeners to all sections to enable dragging
    const sections = document.querySelectorAll('.section');
    sections.forEach((section) => {
      section.addEventListener('dragover', allowDrop);
      section.addEventListener('drop', drop);
    });

    function onSubmit() {
        // Get the section positions from local storage
        const sectionPositions = localStorage.getItem('sectionPositions');

        // Get the hidden sections from local storage
        const hiddenSections = localStorage.getItem('hiddenSections');

        // Append the section positions and hidden sections as hidden inputs in the form
        const form = document.querySelector('form');
        const sectionPositionsInput = document.createElement('input');
        sectionPositionsInput.type = 'hidden';
        sectionPositionsInput.name = 'sectionPositions';
        sectionPositionsInput.value = sectionPositions;
        form.appendChild(sectionPositionsInput);

        const hiddenSectionsInput = document.createElement('input');
        hiddenSectionsInput.type = 'hidden';
        hiddenSectionsInput.name = 'hiddenSections';
        hiddenSectionsInput.value = hiddenSections;
        form.appendChild(hiddenSectionsInput);

        // Submit the form
        form.submit();
    }
  </script>
@endpush