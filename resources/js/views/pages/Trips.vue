<template>
               <Toast />
               <div class="p-grid">
                              <div class="p-col-12">
                                             <div class="card">
                                                            <h1>Chuyến xe</h1>
                                                            <DataTable :value="trips" tableStyle="min-width: 50rem" stripedRows
                                                                           removableSort paginator :rows="5" filterDisplay="row"
                                                                           :rowsPerPageOptions="[5, 10, 20, 50]" :loading="loading"
                                                                           v-model:filters="filters" @row-edit-save="onRowEditSave"
                                                                           ref="dt" v-model:selection="selectedTrips" dataKey="id">
                                                                           <template #header>
                                                                                          <div class="flex justify-content-end">
                                                                                                         <div style="text-align: left"
                                                                                                                        class="mr-2">
                                                                                                                        <Button icon="pi pi-plus"
                                                                                                                                       label="Thêm mới"
                                                                                                                                       @click="openNew"
                                                                                                                                       severity="success" />
                                                                                                         </div>
                                                                                                         <div style="text-align: left"
                                                                                                                        class="mr-2">
                                                                                                                        <Button icon="pi pi-trash"
                                                                                                                                       label="Xóa"
                                                                                                                                       @click="confirmDeleteSelected"
                                                                                                                                       :disabled="!selectedUsers || !selectedUsers.length"
                                                                                                                                       class="p-button-danger" />
                                                                                                         </div>
                                                                                                         <div style="text-align: left"
                                                                                                                        class="mr-2">
                                                                                                                        <Button icon="pi pi-external-link"
                                                                                                                                       label="Tải tệp CSV"
                                                                                                                                       @click="exportCSV($event)" />
                                                                                                         </div>
                                                                                                         <span
                                                                                                                        class="p-input-icon-left">
                                                                                                                        <i
                                                                                                                                       class="pi pi-search" />
                                                                                                                        <InputText v-model="filters['global'].value"
                                                                                                                                       placeholder="Keyword Search" />
                                                                                                         </span>
                                                                                          </div>
                                                                           </template>
                                                                           <template #empty> Không tìm thấy chuyến đi nào</template>
                                                                           <template #loading>
                                                                                          <ProgressSpinner /> Đang tải dữ liệu....
                                                                           </template>
                                                                           <column field="start_date" header="Ngày đi" sortable>
                                                                                          <template #body="{ data }">
                                                                                                         {{ data.start_date }}
                                                                                          </template>
                                                                                          <template
                                                                                                         #filter="{ filterModel, filterCallback }">
                                                                                                         <InputText v-model="filterModel.value"
                                                                                                                        type="date"
                                                                                                                        @input="filterCallback()"
                                                                                                                        class="p-column-filter"
                                                                                                                        placeholder="Tìm theo ngày bắt đầu" />
                                                                                          </template>
                                                                           </column>
                                                                           <column field="end_date" header="Ngày đến" sortable>
                                                                                          <template #body="{ data }">
                                                                                                         {{ data.end_date }}
                                                                                          </template>
                                                                                          <template
                                                                                                         #filter="{ filterModel, filterCallback }">
                                                                                                         <InputText v-model="filterModel.value"
                                                                                                                        type="date"
                                                                                                                        @input="filterCallback()"
                                                                                                                        class="p-column-filter"
                                                                                                                        placeholder="Tìm theo ngày kết thúc" />
                                                                                          </template>
                                                                           </column>
                                                                           <column field="start_location" header="Điểm đi" sortable>
                                                                                          <template #body="{ data }">
                                                                                                         {{ data.start_location }}
                                                                                          </template>
                                                                                          <template
                                                                                                         #filter="{ filterModel, filterCallback }">
                                                                                                         <InputText v-model="filterModel.value"
                                                                                                                        type="text"
                                                                                                                        @input="filterCallback()"
                                                                                                                        class="p-column-filter"
                                                                                                                        placeholder="Tìm theo điểm đi" />
                                                                                          </template>
                                                                           </column>
                                                                           <column field="end_location" header="Điểm đến" sortable>
                                                                                          <template #body="{ data }">
                                                                                                         {{ data.end_location }}
                                                                                          </template>
                                                                                          <template
                                                                                                         #filter="{ filterModel, filterCallback }">
                                                                                                         <InputText v-model="filterModel.value"
                                                                                                                        type="text"
                                                                                                                        @input="filterCallback()"
                                                                                                                        class="p-column-filter"
                                                                                                                        placeholder="Tìm theo điểm đến" />
                                                                                          </template>
                                                                           </column>
                                                                           <column field="total_distance" header="Khoảng cách"
                                                                                          sortable>
                                                                                          <template #body="{ data }">
                                                                                                         {{ data.total_distance }}
                                                                                          </template>
                                                                                          <template
                                                                                                         #filter="{ filterModel, filterCallback }">
                                                                                                         <InputText v-model="filterModel.value"
                                                                                                                        type="text"
                                                                                                                        @input="filterCallback()"
                                                                                                                        class="p-column-filter"
                                                                                                                        placeholder="Tìm theo khoảng cách" />
                                                                                          </template>
                                                                           </column>
                                                                           <column field="total_amount" header="Tổng tiền" sortable>
                                                                                          <template #body="{ data }">
                                                                                                         {{ data.total_amount }}
                                                                                          </template>
                                                                                          <template
                                                                                                         #filter="{ filterModel, filterCallback }">
                                                                                                         <InputText v-model="filterModel.value"
                                                                                                                        type="text"
                                                                                                                        @input="filterCallback()"
                                                                                                                        class="p-column-filter"
                                                                                                                        placeholder="Tìm theo khoảng cách" />
                                                                                          </template>
                                                                           </column>
                                                                           <Column :exportable="false" style="min-width:9rem">
                                                                                          <template #body="slotProps">
                                                                                                         <Button icon="pi pi-pencil"
                                                                                                                        outlined
                                                                                                                        rounded
                                                                                                                        class="mr-2"
                                                                                                                        @click="editTrip(slotProps.data)" />
                                                                                          </template>
                                                                           </Column>

                                                            </DataTable>
                                                            <Dialog v-model:visible="tripDialog" :style="{ width: '80%' }"
                                                                           :modal="true" class="p-fluid">
                                                                           <div class="field">
                                                                                          <label class="label">Mã người dùng</label>
                                                                                          <div class="control">
                                                                                                         <Dropdown v-model="trip.user_id"
                                                                                                                        :options="users_id_list"
                                                                                                                        optionLabel="id"
                                                                                                                        filterBy
                                                                                                                        placeholder="Chọn mã người dùng"
                                                                                                                        filter />
                                                                                          </div>
                                                                                          <small class="p-error"
                                                                                                         v-if="submitted && !trip.user_id">Phải
                                                                                                         chọn mã người dùng</small>
                                                                           </div>
                                                                           <div class="field">
                                                                                          <label class="label">Mã xe</label>
                                                                                          <div class="control">
                                                                                                         <Dropdown v-model="trip.truck_id"
                                                                                                                        :options="truck_id_list"
                                                                                                                        optionLabel="id"
                                                                                                                        placeholder="Chọn mã xe" />
                                                                                          </div>
                                                                                          <small class="p-error"
                                                                                                         v-if="submitted && !trip.truck_id">Phải
                                                                                                         chọn mã xe</small>
                                                                           </div>
                                                                           <div class="field">
                                                                                          <label class="label">Ngày đi</label>
                                                                                          <div class="control">
                                                                                                         <InputText v-model="trip.start_date"
                                                                                                                        type="date" />
                                                                                          </div>
                                                                                          <small class="p-error"
                                                                                                         v-if="submitted && !trip.start_date">Phải
                                                                                                         điền ngày đi</small>
                                                                           </div>
                                                                           <div class="field">
                                                                                          <label class="label">Ngày đến</label>
                                                                                          <div class="control">
                                                                                                         <InputText v-model.trim="trip.end_date"
                                                                                                                        type="date" />
                                                                                          </div>
                                                                                          <small class="p-error"
                                                                                                         v-if="submitted && !trip.end_date">Phải
                                                                                                         điền ngày đến</small>
                                                                           </div>
                                                                           <div class="field">
                                                                                          <label class="label">Điểm đi</label>
                                                                                          <div class="control">
                                                                                                         <InputText v-model.trim="trip.start_location"
                                                                                                                        type="text" />
                                                                                          </div>
                                                                                          <small class="p-error"
                                                                                                         v-if="submitted && !trip.start_location">Phải
                                                                                                         điền điểm đi</small>
                                                                           </div>
                                                                           <div class="field">
                                                                                          <label class="label">Điểm đến</label>
                                                                                          <div class="control">
                                                                                                         <InputText v-model.trim="trip.end_location"
                                                                                                                        type="text" />
                                                                                          </div>
                                                                                          <small class="p-error"
                                                                                                         v-if="submitted && !trip.end_location">Phải
                                                                                                         điền điểm đến</small>
                                                                           </div>
                                                                           <div class="field">
                                                                                          <label class="label">Khoảng cách</label>
                                                                                          <div class="control">
                                                                                                         <InputText v-model.trim="trip.total_distance"
                                                                                                                        type="text" />
                                                                                          </div>
                                                                                          <small class="p-error"
                                                                                                         v-if="submitted && !trip.total_distance">Phải
                                                                                                         điền khoảng cách</small>
                                                                           </div>
                                                                           <div class="field">
                                                                                          <label class="label">Tổng tiền</label>
                                                                                          <div class="control">
                                                                                                         <InputText v-model.trim="trip.total_amount"
                                                                                                                        type="text" />
                                                                                          </div>
                                                                                          <small class="p-error"
                                                                                                         v-if="submitted && !trip.total_amount">Phải
                                                                                                         điền tổng tiền</small>
                                                                           </div>
                                                                           <template #footer>
                                                                                          <Button label="Hủy" icon="pi pi-times" text
                                                                                                         @click="hideDialog" />
                                                                                          <Button label="Lưu" icon="pi pi-check"
                                                                                                         class="p-button-success" text
                                                                                                         @click="saveTrip" />
                                                                           </template>
                                                            </Dialog>
                                             </div>
                              </div>
               </div>
</template>
<script>
import { ref, onMounted } from 'vue';
import { FilterMatchMode } from 'primevue/api';
import axios from 'axios';
import { useToast } from 'primevue/usetoast';
export default {
               setup() {
                              const toast = useToast();
               },
               data() {
                              return {
                                             trips: null,
                                             loading: true,
                                             columns: null,
                                             tripDialog: false,
                                             submitted: false,
                                             users_id_list: [],
                                             truck_id_list: [],
                                             user_id: null,
                                             truck_id: null,
                                             filters: {
                                                            global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                                                            start_date: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                                            end_date: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                                            start_location: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                                            end_location: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                                            total_distance: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                                            total_amount: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                             },
                                             trip: {
                                                            id: null,
                                                            start_date: null,
                                                            end_date: null,
                                                            start_location: null,
                                                            end_location: null,
                                                            total_distance: null,
                                                            total_amount: null,
                                                            user_id: null,
                                                            truck_id: null
                                             },
                              };
               },
               mounted() {
                              axios.get("http://127.0.0.1:8000/api/trips")
                                             .then(res => {
                                                            this.trips = res.data;
                                                            this.loading = false;
                                             })
                                             .catch(err => {
                                                            console.log(err);
                                             });
                              this.getUser();
                              this.getTruck();
               },
               methods: {
                              editTrip(trip) {
                                             this.trip = { ...trip };
                                             this.tripDialog = true;
                              },
                              hideDialog() {
                                             this.tripDialog = false;
                                             this.submitted = false;
                              },
                              saveTrip() {
                                             this.submitted = true;
                                             if (this.trip.start_date && this.trip.end_date && this.trip.start_location && this.trip.end_location && this.trip.total_distance && this.trip.total_amount && this.trip.user_id && this.trip.truck_id) {
                                                            this.trip.user_id = this.trip.user_id.id;
                                                            this.trip.truck_id = this.trip.truck_id.id;
                                                            console.log(this.trip);
                                                            if (this.trip.id) {
                                                                           axios.put(`http://127.0.0.1:8000/api/trips/${this.trip.id}`, this.trip)
                                                                                          .then(res => {
                                                                                                         this.$toast.add({
                                                                                                                        severity: "success",
                                                                                                                        summary: "Thành công",
                                                                                                                        detail: "Chuyến đi đã được cập nhật",
                                                                                                                        life: 3000
                                                                                                         });
                                                                                                         this.tripDialog = false;
                                                                                                         this.trip = {};
                                                                                          })
                                                                                          .catch(err => {
                                                                                                         console.log(err);
                                                                                          });
                                                            }
                                                            else {
                                                                           axios.post("http://127.0.0.1:8000/api/trips", this.trip)
                                                                                          .then(res => {
                                                                                                         this.$toast.add({
                                                                                                                        severity: "success",
                                                                                                                        summary: "Thành công",
                                                                                                                        detail: "Chuyến đi đã được thêm",
                                                                                                                        life: 3000
                                                                                                         });
                                                                                                         this.tripDialog = false;
                                                                                                         this.trip = {};
                                                                                                         this.submitted = false;
                                                                                          })
                                                                                          .catch(err => {
                                                                                                         console.log(err);
                                                                                                         this.$toast.add({
                                                                                                                        severity: "error",
                                                                                                                        summary: "Lỗi",
                                                                                                                        detail: "Chuyến đi chưa được thêm",
                                                                                                                        life: 3000
                                                                                                         });
                                                                                          });

                                                            }
                                             }
                                             this.trip = null;
                                             this.tripDialog = false;
                              },
                              getUser() {
                                             axios.get("http://127.0.0.1:8000/api/users")
                                                            .then(res => {
                                                                           this.users_id_list = res.data;
                                                            })
                                                            .catch(err => {
                                                                           console.log(err);
                                                            });
                              },
                              getTruck() {
                                             axios.get("http://127.0.0.1:8000/api/users")
                                                            .then(res => {
                                                                           this.truck_id_list = res.data;
                                                            })
                                                            .catch(err => {
                                                                           console.log(err);
                                                            });
                              },
                              openNew() {
                                             this.trip = {};
                                             this.submitted = false;
                                             this.tripDialog = true;
                              }
               }
}
</script>