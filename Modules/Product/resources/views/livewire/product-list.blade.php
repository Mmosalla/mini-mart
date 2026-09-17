@php use Modules\Product\Enums\ProductEnum; @endphp
<main class="main-content">
    <style>
        .btn-add-product {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 22px 10px 16px;
            border: none;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            cursor: pointer;
            overflow: hidden;
            background: linear-gradient(135deg, #6366f1, #8b5cf6, #ec4899);
            background-size: 200% 200%;
            animation: gradientMove 4s ease infinite;
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.35);
            transition: all 0.35s cubic-bezier(0.22, 1, 0.36, 1);
        }

        /* گرادیان متحرک */
        @keyframes gradientMove {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* افکت درخشش (Shimmer) */
        .btn-add-product::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                120deg,
                transparent,
                rgba(255, 255, 255, 0.35),
                transparent
            );
            transition: left 0.6s ease;
        }

        .btn-add-product:hover::before {
            left: 100%;
        }

        .btn-add-product:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 15px 35px rgba(139, 92, 246, 0.5);
        }

        .btn-add-product:active {
            transform: translateY(-1px) scale(0.99);
        }

        /* آیکون با پس‌زمینه دایره‌ای */
        .btn-add-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(4px);
            font-size: 14px;
            transition: transform 0.35s ease;
        }

        .btn-add-product:hover .btn-add-icon {
            transform: rotate(180deg) scale(1.1);
            background: rgba(255, 255, 255, 0.4);
        }

        /* پالس دور دکمه */
        .btn-add-product::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 40px;
            box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.6);
            animation: pulseGlow 2.5s infinite;
            pointer-events: none;
        }

        @keyframes pulseGlow {
            0% {
                box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.5);
            }
            70% {
                box-shadow: 0 0 0 14px rgba(139, 92, 246, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(139, 92, 246, 0);
            }
        }

        /* ریسپانسیو */
        @media (max-width: 576px) {
            .btn-add-product {
                padding: 8px 16px 8px 12px;
                font-size: 13px;
            }

            .btn-add-text {
                display: none;
            }

            .btn-add-icon {
                width: 24px;
                height: 24px;
            }
        }
    </style>
    <style>
        .upload-progress {
            width: 100%;
            height: 8px;
            margin-top: 10px;
            background: #e9ecef;
            border-radius: 5px;
            overflow: hidden;
        }

        .upload-progress-bar {
            width: 0;
            height: 100%;
            background: #6366f1;
            border-radius: 5px;
            transition: width 0.2s ease;
        }
    </style>

    @include('dashboard::components.layouts.loader')

    @if($create_mode === true || $update_mode === true)
        <div style="border-radius: 30px" class="card">
            <div class="card-body">
                @if($create_mode)
                    <h4 class="card-title">افزودن محصول جدید</h4>
                @elseif($update_mode)
                    <h4 class="card-title">ویرایش محصول </h4>
                @endif
                <form>
                    <!-- ردیف ۱: نام + برند -->
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label">نام محصول</label>
                            <input wire:model="name" type="text" class="form-control" name="name"
                                   placeholder="نام محصول را وارد کنید">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label">برند محصول</label>
                            <input wire:model="brand" type="text" class="form-control" name="brand"
                                   placeholder="برند محصول را وارد کنید">
                        </div>
                    </div>

                    <!-- ردیف ۲: دسته‌بندی چندسلکت -->
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label class="col-form-label">دسته‌بندی‌ها (چند انتخابی)</label>
                            <select wire:model="categoryIds" class="form-control" name="categories[]" multiple>
                                <option value="0">لطفاً حداقل یک دسته‌بندی انتخاب کنید.</option>
                                @foreach($categories as $key=>$value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">برای انتخاب چندگانه، کلید Ctrl (ویندوز) یا Cmd (مک) را نگه
                                دارید.</small>
                        </div>
                    </div>

                    <!-- ردیف ۳: قیمت + تخفیف -->
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label">قیمت اصلی محصول (تومان)</label>
                            <input wire:model="price" type="text" class="form-control" name="price"
                                   placeholder="مثلاً ۱,۲۰۰,۰۰۰">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="col-form-label">تخفیف محصول (٪)</label>
                            <input wire:model="discount" type="number" class="form-control" name="discount" min="0"
                                   max="100" placeholder="مثلاً 15">
                        </div>
                    </div>

                    <!-- ردیف ۴: آپلود عکس با نوار پیشرفت -->
                    <div
                        x-data="{ uploading: false, progress: 0 }"
                        x-on:livewire-upload-start="uploading = true"
                        x-on:livewire-upload-finish="uploading = false"
                        x-on:livewire-upload-cancel="uploading = false"
                        x-on:livewire-upload-error="uploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                        class="form-row">

                        <div class="col-md-12 mb-3">
                            <label class="col-form-label">عکس محصول</label>
                            <input wire:ignore wire:model="image" type="file" class="form-control-file" name="image"
                                   id="productImage">

                            <div class="upload-progress">
                                <div x-bind:style="`width:${progress}%`" class="upload-progress-bar"
                                     id="uploadBar"></div>
                            </div>
                            <div class="upload-info">
                                <span id="uploadPercent" x-text="`${progress}%`"></span>
                            </div>
                        </div>
                    </div>

                    <!-- ردیف ۵: توضیحات -->
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label class="col-form-label">توضیحات محصول</label>
                            <textarea wire:model="short_description" class="form-control" name="description" rows="4"
                                      placeholder="توضیحات کامل محصول را اینجا بنویسید..."></textarea>
                        </div>
                    </div>

                    <!-- ردیف ۶: دکمه ثبت -->
                    <div class="form-row">
                        @if($create_mode)
                            <div class="col-md-12">
                                <button wire:click.prevent="CreateProduct" class="btn btn-success btn-uppercase">
                                    <i class="ti-check-box m-r-5"></i> ذخیره محصول
                                </button>
                            </div>
                            <div style="margin-top: 30px" class="col-md-12">
                                <button wire:click.prevent="cancelCreateProduct" class="btn btn-danger btn-uppercase">
                                    <i class="ti-close m-r-5"></i> انصراف
                                </button>
                            </div>
                        @elseif($update_mode)
                            <div class="col-md-12">
                                <button wire:click.prevent="UpdateProduct" class="btn btn-info btn-uppercase">
                                    <i class="ti-check-box m-r-5"></i> ویراش محصول
                                </button>
                            </div>
                            <div style="margin-top: 30px" class="col-md-12">
                                <button wire:click.prevent="cancelUpdateProduct" class="btn btn-danger btn-uppercase">
                                    <i class="ti-close m-r-5"></i> انصراف
                                </button>
                            </div>
                        @endif
                    </div>

                </form>
            </div>
        </div>
    @endif

    @if($form_mode === true  )
        <div class="d-flex align-items-center mb-3 flex-wrap">
            <h4 class="card-title mb-0 mr-auto">لیست محصولات</h4>
            <div class="ml-auto d-flex align-items-center" style="gap: 10px;">
                <input wire:model="search" @keyup.enter="$wire.searchData" type="text"
                       class="form-control form-control-sm" placeholder="جستجو..." style="width:220px;">
                <!-- دکمه افزودن محصول -->
                <button wire:click.prevent="CreateMode" type="button" class="btn-add-product">
            <span class="btn-add-icon">
                <i class="ti-plus"></i>
            </span>
                    <span class="btn-add-text">افزودن محصول</span>
                </button>
            </div>
        </div>
        <!-- ===== کارت جدول محصولات ===== -->
        <div style="border-radius: 30px" class="card">
            <div class="card-body">
                <div style="border-radius: 5px" class="table overflow-auto" tabindex="8">
                    <table class="table table-striped table-hover">
                        <thead class="thead-light">
                        <tr>
                            <th class="text-center align-middle text-primary">ردیف</th>
                            <th class="text-center align-middle text-primary">عکس</th>
                            <th class="text-center align-middle text-primary">نام محصول</th>
                            <th class="text-center align-middle text-primary">قیمت(با احتساب تخفیف)</th>
                            <th class="text-center align-middle text-primary">تاریخ ایجاد</th>
                            <th class="text-center align-middle text-primary">وضعیت</th>
                            <th class="text-center align-middle text-primary">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($this->Products as $index => $product)
                            <tr>
                                <td class="text-center align-middle">{{$this->Products->firstItem() + $index}}</td>
                                <td class="text-center align-middle">
                                    <img src="{{url('Images/Products/'.$product->image)}}" alt="product"
                                         class="table-avatar">
                                </td>
                                <td class="text-center align-middle">{{$product->name}}</td>
                                <td class="text-center align-middle">
                                    {{number_format( $product->price - ($product->price * $product->discount / 100))}}
                                    تومان
                                </td>
                                <td class="text-center align-middle">{{\Hekmatinasser\Verta\Verta::instance($product->created_at)->formatJalaliDate()}}</td>
                                <td class="text-center align-middle">
                                    @if($product->status === ProductEnum::Draft->value)
                                        <button
                                            wire:click="changeStatus({{ $product->id }}, '{{ ProductEnum::Active->value }}')"
                                            type="button" class="status-badge btn btn-secondary">پیش فرض
                                        </button>
                                    @elseif($product->status === ProductEnum::Inactive->value)
                                        <button
                                            wire:click="changeStatus({{ $product->id }}, '{{ ProductEnum::Draft->value }}')"
                                            type="button" class="status-badge btn btn-danger">غیر فعال
                                        </button>
                                    @elseif($product->status === ProductEnum::Active->value)
                                        <button
                                            wire:click="changeStatus({{ $product->id }}, '{{ ProductEnum::Inactive->value }}')"
                                            type="button" class="status-badge btn btn-success">فعال
                                        </button>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <button wire:click.prevent="EditProduct({{$product->id}})"
                                            class="btn btn-outline-info btn-action" title="ویرایش">
                                        <i class="ti-pencil"></i>
                                    </button>
                                    <button wire:click.prevent="ShowDetailProduct({{$product_id}})"
                                            class="btn btn-outline-primary btn-action" title="مشاهده جزئیات"
                                            data-toggle="modal" data-target="#productModal">
                                        <i class="ti-eye"></i>
                                    </button>
                                    <button wire:click="$dispatch('delete-product',{product_id:{{$product->id}}})"
                                            class="btn btn-outline-danger btn-action" title="حذف">
                                        <i class="ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    😑نتیجه‌ای یافت نشد😑
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="pagination pagination-rounded pagination-sm d-flex justify-content-center"
                         style="margin: 40px !important;">
                        {{$this->Products->links()}}
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== مودال مشاهده جزئیات محصول ===== -->
        <div class="modal fade" id="productModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">جزئیات محصول</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img src="assets/media/image/avatar.png" alt="product" class="img-fluid rounded mb-3"
                                     style="max-width: 200px;">
                            </div>
                            <div class="col-md-8">
                                <h5>نام محصول</h5>
                                <hr>
                                <p><strong>برند:</strong> ...</p>
                                <p><strong>قیمت:</strong> ...</p>
                                <p><strong>تخفیف:</strong> ...</p>
                                <p><strong>دسته‌بندی‌ها:</strong> ...</p>
                                <p><strong>تاریخ ایجاد:</strong> ...</p>
                                <p><strong>وضعیت:</strong> ...</p>
                                <p><strong>توضیحات:</strong> ...</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</main>

@push('scripts')
    <script>
        Livewire.on('delete-product', (event) => {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: "آیا حذف را تایید میکنید؟",
                icon: "warning",
                text: "با حذف این محصول، آن به طور دائم حذف خواهد شد و دیگر قابل دسترسی و بازیابی نخواهد بود. آیا از حذف اطمینان دارید؟",
                showCancelButton: true,
                confirmButtonText: "بله",
                cancelButtonText: "خیر",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('destroyProduct', {product_id: event.product_id})
                    swalWithBootstrapButtons.fire({
                        title: "حذف با موفقیت انجام شد!",
                        icon: "success"
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire({
                        title: "حذف  لغو شد",
                        icon: "error"
                    });
                }
            });

        })
        Livewire.on('productCreated', () => {
            const toast = window.Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                padding: '2em',
            });

            toast.fire({
                icon: 'success',
                title: ' محصول با موفقیت اضافه شد',
                padding: '2em',
            });
        });
        Livewire.on('cancelCreateProduct', () => {
            const toast = window.Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                padding: '2em',
            });

            toast.fire({
                icon: 'warning',
                title: 'ساخت محصول لغو شد!',
                padding: '2em',
            });
        });
        Livewire.on('statusChanged', () => {
            const toast = window.Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                padding: '2em',
            });

            toast.fire({
                icon: 'success',
                title: 'وضعیت با موفقیت تغییر کرد',
                padding: '2em',
            });
        });
        Livewire.on('UpdateProductCanceled', () => {
            const toast = window.Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                padding: '2em',
            });

            toast.fire({
                icon: 'warning',
                title: 'ویرایش محصول لفو شد!',
                padding: '2em',
            });
        });
    </script>
@endpush
