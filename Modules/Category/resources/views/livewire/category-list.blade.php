<main class="main-content">
    <!-- ===== کارت فرم افزودن دسته‌بندی (یک‌خطی) ===== -->
    <div style="border-radius: 30px" class="card">
        <div class="card-body">
            @if($editIndex == null)
                <h4 class="card-title">افزودن دسته‌بندی جدید</h4>
            @elseif($editIndex =! null)
                <h4 class="card-title">ویرایش دسته‌بندی </h4>
            @endif
            <form>
                <div class="form-row align-items-end">
                    <!-- نام دسته‌بندی -->
                    <div class="col-md-3 mb-2">
                        <label class="col-form-label">نام دسته‌بندی</label>
                        <input type="text" wire:model="name" class="form-control" dir="rtl" name="category_name"
                               placeholder="نام دسته‌بندی">
                    </div>
                    <!-- والد -->
                    <div class="col-md-3 mb-2">
                        <label class="col-form-label">دسته‌بندی والد</label>
                        <select wire:model="parent_category" class="form-control" name="parent_category">
                            <option value="0">دسته بندی اصلی</option>
                            @foreach($parent_categories as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- دکمه ذخیره -->
                    <div class="col-md-3 mb-2">
                        @if($editIndex == null)
                            <button wire:click.prevent="creatCategory" class="btn btn-success btn-uppercase btn-block">
                                <i class="ti-check-box m-r-5"></i> ذخیره
                            </button>
                        @else
                            <div class="d-flex gap-2">
                                <button wire:click.prevent="UpdateCategory"
                                        class="btn btn-info btn-sm btn-uppercase btn-block">
                                    <i class="ti-check-box m-r-5"></i> ویرایش
                                </button>
                                <button wire:click.prevent="cancelEdit"
                                        class="btn btn-danger btn-sm btn-uppercase btn-block">
                                    <i class="ti-close m-r-5"></i> انصراف
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('dashboard::components.layouts.loader')

    <div style="border-radius: 30px" class="card">
        <div class="form-group row">
            <label style="position: relative ;top: 3px ; right: 60px" class="col-sm-2 col-form-label">عنوان جستجو
                :</label>
            <div style="margin-top: 6px" class="col-sm-8">
                <input type="text" wire:model="search" @keyup.enter="$wire.searchData" class="form-control text-left"
                       dir="rtl">
            </div>
        </div>

        <!-- لودر (اسپینر) – می‌تونی با شرط خودت نمایش بدی -->


        <div style="border-radius: 30px" class="table overflow-auto" tabindex="8">
            <table class="table table-striped table-hover">
                <thead class="thead-light">
                <tr>
                    <th class="text-center align-middle text-primary">ردیف</th>
                    <th class="text-center align-middle text-primary">نام دسته‌بندی</th>
                    <th class="text-center align-middle text-primary">والد</th>
                    <th class="text-center align-middle text-primary">تاریخ ایجاد</th>
                    <th class="text-center align-middle text-primary">وضعیت</th>
                    <th class="text-center align-middle text-primary">عملیات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($this->Categories as $index => $category)
                    <tr>
                        <td class="text-center align-middle">
                            {{ $this->Categories->firstItem() + $index }}
                        </td>

                        <td class="text-center align-middle">
                            {{ $category->name }}
                        </td>

                        <td class="text-center align-middle">
                            {{ $category->parentCategory->name }}
                        </td>

                        <td class="text-center align-middle">
                            {{ \Hekmatinasser\Verta\Verta::instance($category->created_at)->formatJalaliDate() }}
                        </td>
                        <td class="text-center align-middle">
                            @if($category->status == \Modules\Category\Enums\CategoryStatus::Active->value)
                                <button wire:click.prevent="changeToInActive({{$category->id}})" type="button"
                                        style="padding: 3px ; border-radius: 20px" title="برای تغییر وضعیت کلیک کنبد"
                                        class="status-badge status-active bg-success">فعال
                                </button>
                            @else
                                <button wire:click.prevent="changeToActive({{$category->id}})" type="button"
                                        style="padding: 3px ; border-radius: 20px" title="برای تغییر وضعیت کلیک کنبد"
                                        class="status-badge status-active bg-danger">غیره فعال
                                </button>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            <button
                                wire:click.prevent="editCategory({{ $category->id }})"
                                class="btn btn-outline-info btn-sm"
                                title="ویرایش"
                            >
                                <i class="ti-pencil"></i>
                            </button>

                            <button
                                wire:click="$dispatch('delete-category',{category_id:{{$category->id}}})"
                                class="btn btn-outline-danger btn-sm"
                                title="حذف"
                            >
                                <i class="ti-trash"></i>
                            </button>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            😑نتیجه‌ای یافت نشد😑
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <!-- صفحه‌بندی -->
            <div class="pagination pagination-rounded pagination-sm d-flex justify-content-center"
                 style="margin: 40px !important;">
                {{$this->Categories->links()}}
            </div>
        </div>
    </div>
</main>

@push('scripts')

    <script>
        Livewire.on('delete-category', (event) => {
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
                text: "با حذف این دسته‌بندی، تمامی زیرگروه‌های آن نیز حذف خواهند شد و دیگر قابل دسترسی نخواهند بود. آیا مطمئن هستید؟",
                showCancelButton: true,
                confirmButtonText: "بله",
                cancelButtonText: "خیر",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('destroy-category', {category_id: event.category_id})
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
        Livewire.on('CategoryCreated', () => {
            const toast = window.Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                padding: '2em',
            });

            toast.fire({
                icon: 'success',
                title: 'دسته‌بندی با موفقیت اضافه شد',
                padding: '2em',
            });
        });
        Livewire.on('CategoryCanceled', () => {
            const toast = window.Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                padding: '2em',
            });

            toast.fire({
                icon: 'warning',
                title: 'ویرایش دسته بندی لغو شد!',
                padding: '2em',
            });
        });
        Livewire.on('CategoryUpdated', () => {
            const toast = window.Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                padding: '2em',
            });

            toast.fire({
                icon: 'success',
                title: 'دسته‌بندی با موفقیت ویرایش شد',
                padding: '2em',
            });
        });
        Livewire.on('CategoryStatusChanged', () => {
            const toast = window.Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                padding: '2em',
            });

            toast.fire({
                icon: 'success',
                title: 'وضعیت دسته‌بندی با موفقیت عوض شد',
                padding: '2em',
            });
        });
    </script>
@endpush

