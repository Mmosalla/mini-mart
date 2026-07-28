@php use Hekmatinasser\Verta\Verta;use Modules\User\Enums\UserStatusEnums; @endphp
<div>

    <main class="main-content">
        <div  wire:loading.flex wire:target="search,chengToActive,chengToInactive,gotoPage,nextPage,previousPage" class="spinner-border"  role="status">
            <span class="sr-only">در حال بارگذاری ...</span>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table overflow-auto" tabindex="8">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">عنوان جستجو</label>
                        <div class="col-sm-10">
                            <input wire:model="search" @keyup.enter="$wire.searchData" type="text" class="form-control text-left" dir="rtl" wire:model="search">
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead class="thead-light">
                        <tr>
                            <th class="text-center align-middle text-primary">ردیف</th>
                            <th class="text-center align-middle text-primary">عکس</th>
                            <th class="text-center align-middle text-primary">نام کاریری</th>
                            <th class="text-center align-middle text-primary">موبایل</th>
                            <th class="text-center align-middle text-primary"> وضعیت</th>
                            <th class="text-center align-middle text-primary">تاریخ ایجاد</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($this->users as $index=>$user)
                            <tr>
                                <td class="text-center align-middle">{{$this->users->firstItem() + $index}}</td>
                                <td class="text-center align-middle">
                                    <figure class="avatar avatar">
                                        @if($user->image)
                                            <img src="{{url('images/users/avatar/' . $user->image)}}" class="rounded-circle"
                                                 alt="mini_mart">
                                        @else
                                            <img src="{{url('images/AvatarDefultImage/images.png')}}" class="rounded-circle"
                                                 alt="mini_mart">
                                        @endif
                                    </figure>
                                </td>
                                <td class="text-center align-middle">{{$user->name}}</td>
                                <td class="text-center align-middle">{{$user->mobile}}</td>

                                <td class="text-center align-middle">
                                    @if($user->status == UserStatusEnums::ACTIVE->value)
                                        <span wire:click.prevent="chengToInactive({{$user->id}})" data-toggle="tooltip" data-placement="top"  data-original-title="برای تغییر وضعیت کیلیک کن!" aria-describedby="tooltip835268" class="cursor-pointer badge badge-success">فعال</span>
                                    @elseif($user->status == UserStatusEnums::INACTIVE->value)
                                        <span wire:click.prevent="chengToActive({{$user->id}})" data-toggle="tooltip" data-placement="top"  data-original-title="برای تغییر وضعیت کیلیک کن!" aria-describedby="tooltip835268" class="cursor-pointer badge badge-danger">غیره فعال</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">{{Verta::instance($user->created_at)}}</td>

                            </tr>
                        @endforeach


                    </table>
                    <div style="margin: 40px !important;" class="pagination pagination-rounded pagination-sm d-flex justify-content-center">
                        {{$this->users->links()}}
                    </div>
                </div>
            </div>
        </div>
    </main>

</div>
