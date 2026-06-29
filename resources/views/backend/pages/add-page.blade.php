@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-file-alt" style="color:#6366f1;margin-right:8px;"></i>
                    @if (isset($page)) Edit Custom Page @else Add Custom Page @endif
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('pages.index') }}" style="color:#6366f1;text-decoration:none;">Custom Pages</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    @if (isset($page)) Edit @else Add @endif
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('pages.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> Custom Pages List
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-cog" style="color:#6366f1;margin-right:6px;"></i>
                            Custom Page Configuration Form
                        </span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form method="post"
                            action="{{ isset($page) ? route('pages.update', $page->id) : route('pages.store') }}"
                            id="myForm">
                            @csrf
                            @isset($page) 
                                @method('PUT') 
                            @endisset
                            
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="name" style="font-weight:600;color:#334155;font-size:13px;">Page Title Heading <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ old('name', $page->name ?? '') }}"
                                        class="form-control" id="name" placeholder="e.g. Terms and Conditions" required>
                                    @error('name')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                        
                                <div class="form-group col-md-12">
                                    <label for="summernote" style="font-weight:600;color:#334155;font-size:13px;">Page Content Details <span class="text-danger">*</span></label>
                                    <textarea name="description" id="summernote" class="form-control" rows="8"
                                        placeholder="Enter Page contents..." required>{{ old('description', $page->description ?? '') }}</textarea>
                                    @error('description')
                                        <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                        
                                <div class="form-group col-md-12 text-right mt-3" style="border-top:1px solid #e2e8f0;padding-top:20px;margin-bottom:0;">
                                    <button type="submit" class="btn btn-primary px-4" style="background:#6366f1;border:none;font-weight:600;padding:10px 24px;border-radius:8px;">
                                        <i class="fas fa-save mr-1"></i> {{ isset($page) ? 'Update Page' : 'Save Page' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function() {
            $('#summernote').summernote({
                height: 280,
                callbacks: {
                    onChange: function(contents, $editable) {
                        $('#summernote').val(contents);
                    }
                }
            });

            $('#myForm').validate({
                rules: {
                    name: {
                        required: true
                    },
                    description: {
                        required: true
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
