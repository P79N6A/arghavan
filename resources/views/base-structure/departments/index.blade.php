
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-content">

                    <!-- Title -->
                    <h3 class="card-title col-sm-12">
                        <div>
                            {{-- <i class="material-icons md-48">business</i> --}}
                            <i class="fas fa-building fa-2x"></i>
                            <span class="panel-heading"> ساختمان ها</span>

                            @can('command_insert')
                                <!-- Pc size -->
                                <span class="pull-left pc" v-show="isNormalMode">
                                    <a class="btn btn-round btn-rose"
                                        href="#"
                                        @click.prevent="newRecord">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        ثبت رکورد جدید
                                    </a>
                                </span>
                                 <!--  mobile size -->
                                <span class="mobile" v-show="isNormalMode">
                                    <a class="btn btn-round btn-rose"
                                        href="#"
                                        @click.prevent="newRecord">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        ثبت رکورد جدید
                                    </a>
                                </span>
                            @endcan

                        </div>
                    </h3>
                    <!-- /Title -->

                    <div class="row">
                        <!-- Data list -->
                        <div v-show="isNormalMode">
                            <div class="text-left">
                            </div>

                            <div v-if="! hasDepartmentRows">
                                <h4 class="text-center f-BYekan">
                                    رکوردی ثبت نشده است
                                </h4>
                            </div>
                            <!-- List Data Table -->
                            <div class="table-responsive col-md-12 pc">
                                <table id="myTable"
                                    class="table table-striped table-hover "
                                    v-show="hasDepartmentRows">
                                    <thead v-show="!isLoading">
                                        <td>نام ساختمان</td>
                                        <td></td>
                                    </thead>
                                    <tbody>
                                        <tr v-if="isLoading">
                                            <td colspan="2" class="text-center">در حال بارگذاری اطلاعات</td>
                                        </tr>

                                        <tr v-for="record in departments">
                                            <td>@{{ record.name }}</td>
                                            <td class="text-left" width="160">
                                                @can('command_delete')
                                                    <a href="#" class="btn btn-round btn-just-icon pull-left"
                                                        data-toggle="modal"
                                                        data-target="#removeRecordModalDepartment"
                                                        @click.prevent="readyToDelete(record, Department)">
                                                        <i class="material-icons">delete</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                @endcan
                                                @can('command_edit')
                                                    <a href="#" class="btn btn-round btn-info btn-just-icon pull-left"
                                                        @click.prevent="editRecord(record)">
                                                        <i class="material-icons">create</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <card-mobile
                                        v-for="record in departments"
                                        :key= "record.id"
                                        :my-data="record"
                                        @edit-data="editRecord"
                                        @delete-data="readyToDelete(record)"
                                        title="نام ساختمان">
                            </card-mobile>

                            <div class="text-center">
                                <pagination :data="departments_paginate"
                                            v-on:pagination-change-page="loadDepartments"
                                            :limit= "{{ \App\Http\Controllers\Controller::C_PAGINATION_LIMIT }}"
                                            :show-disable= "true">
                                </pagination>
                            </div>
                        </div>
                        <!--  /Data List  -->

                        <!-- Register Form -->
                        <div v-show="isRegisterMode">
                            @include('base-structure.departments.create')
                        </div>
                        <!-- /Register Form -->

                        <!-- small modal -->
                        <div class="modal fade"
                            id="removeRecordModalDepartment"
                            tabindex="-1"
                            role="dialog"
                            aria-labelledby="myModalLabel"
                            aria-hidden="true">

                            <div class="modal-dialog modal-small ">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button"
                                                class="close"
                                                data-dismiss="modal"
                                                aria-hidden="true">
                                                <i class="material-icons">clear</i>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <h5>برای حذف اطمینان دارید؟ </h5>
                                    </div>
                                    <div class="modal-footer text-center">
                                        <button type="button"
                                                class="btn btn-label"
                                                data-dismiss="modal">خیر
                                        </button>
                                        <button type="button"
                                                class="btn btn-rose"
                                                data-dismiss="modal"
                                                @click.prevent="deleteRecord('departments')">بله
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--    end small modal -->

                    </div>
                </div>
            </div>
        </div>
    </div>
