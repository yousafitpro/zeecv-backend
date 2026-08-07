<div class="row no-gutters" >
    @foreach ($images as $imageItem)
        @if ($imageItem->appfile && $imageItem->appfile->file_url)
            <div class="col-md-2 col-sm-4 col-6 mb-4">
                <div class="position-relative border rounded shadow-sm overflow-hidden">
                    <img src="{{ $imageItem->appfile->file_url }}"
                         class="img-fluid rounded"
                         style="height: 160px; object-fit: cover; width: 100%;">
                           <button type="button"
                           data-toggle="modal"
                           data-target="#imageModal{{$imageItem->id}}"
                        class="btn btn-sm  position-absolute btn_close"
                        style="top: 8px; right: 8px; z-index: 10;"
                      >
                        <i class="fas fa-eye"></i>
                    </button>
                <div class="modal fade" id="imageModal{{$imageItem->id}}" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">

                            {{-- <div class="modal-header">
                                <h5 class="modal-title">Image Preview</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-close"></i></button>
                            </div> --}}

                            <div class="modal-body text-center">
                                <img src="{{ $imageItem->appfile->file_url }}" id="fullImage" class="img-fluid" style="max-height: 90vh;">
                            </div>

                        </div>
                    </div>
                </div>


 @if(is_has_permission('pmm.products.update'))

                     <button type="button"
                        class="btn btn-sm position-absolute btn_close"
                        style="top: 30px; right:8px; z-index: 10;"
                        onclick="removeImage('{{route('pmm.products.image_remove',$imageItem->id)}}')">
                        <i class="fas fa-trash"></i>
                    </button>
                    @endif
                </div>
            </div>
        @endif
    @endforeach
</div>
