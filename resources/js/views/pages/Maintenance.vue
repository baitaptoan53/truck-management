<template>
               <Toast />
               <div class="p-grid">
                              <div class="p-col-12">
                                             <div class="card">
                                                            <DataTable :value="maintenances" tableStyle="min-width: 50rem"
                                                                           :rowsPerPageOptions="[5, 10, 20, 50]" stripedRows
                                                                           removableSort paginator :rows="5" filterDisplay="row"
                                                                           :loading="loading" v-model:filters="filters" dataKey="id"
                                                                           :globalFilterFields="['manufacturer', 'model', 'year', 'license_plate', 'vin_number', 'registration_date', 'curent_mileage']"
                                                                           v-model:selection="selectedTrucks" ref="dt"
                                                                           @row-edit-save="onRowEditSave">
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
                                                                                                                        <Button icon="pi pi-external-link"
                                                                                                                                       label="Tải tệp CSV"
                                                                                                                                       @click="exportCSV($event)" />
                                                                                                         </div>
                                                                                                         <span
                                                                                                                        class="p-input-icon-left">
                                                                                                                        <i
                                                                                                                                       class="pi pi-search" />
                                                                                                                        <InputText v-model="filters['global'].value"
                                                                                                                                       placeholder="Từ khóa" />
                                                                                                         </span>
                                                                                          </div>
                                                                           </template>
                                                                           <template #empty> Không có xe thông tin bảo dưỡng nào
                                                                           </template>
                                                                           <template #loading>
                                                                                          <ProgressSpinner /> Đang tải
                                                                                          dữ liệu ...
                                                                           </template>
                                                                           <Column field="truck_id" header="Mã xe" sortable>
                                                                                          <template #body="{ data }">
                                                                                                         {{ data.truck_id }}
                                                                                          </template>
                                                                                          <template
                                                                                                         #filter="{ filterModel, filterCallback }">
                                                                                                         <InputText v-model="filterModel.value"
                                                                                                                        type="text"
                                                                                                                        @input="filterCallback()"
                                                                                                                        class="p-column-filter"
                                                                                                                        placeholder="Tìm mã xe" />
                                                                                          </template>
                                                                           </Column>
                                                                           <Column field="description" header="Mô tả" sortable>
                                                                                          <template #body="{ data }">
                                                                                                         {{ data.description }}
                                                                                          </template>
                                                                                          <template
                                                                                                         #filter="{ filterModel, filterCallback }">
                                                                                                         <InputText v-model="filterModel.value"
                                                                                                                        type="text"
                                                                                                                        @input="filterCallback()"
                                                                                                                        class="p-column-filter"
                                                                                                                        placeholder="Tìm mô tả" />
                                                                                          </template>
                                                                           </Column>
                                                                           <Column field="cost" header="Chi phí" sortable>
                                                                                          <template #body="{ data }">
                                                                                                         {{ data.cost }}
                                                                                          </template>
                                                                                          <template
                                                                                                         #filter="{ filterModel, filterCallback }">
                                                                                                         <InputText v-model="filterModel.value"
                                                                                                                        type="number"
                                                                                                                        @input="filterCallback()"
                                                                                                                        class="p-column-filter"
                                                                                                                        placeholder="Tìm chi phí" />
                                                                                          </template>
                                                                           </Column>
                                                                           <Column field="maintenance_date" header="Ngày bảo dưỡng"
                                                                                          sortable>
                                                                                          <template #body="{ data }">
                                                                                                         {{ data.maintenance_date }}
                                                                                          </template>
                                                                                          <template
                                                                                                         #filter="{ filterModel, filterCallback }">
                                                                                                         <InputText v-model="filterModel.value"
                                                                                                                        type="date"
                                                                                                                        @input="filterCallback()"
                                                                                                                        class="p-column-filter"
                                                                                                                        placeholder="Tìm ngày bảo dưỡng" />
                                                                                          </template>
                                                                           </Column>
                                                                           <Column :exportable="false" style="min-width:9rem">
                                                                                          <template #body="slotProps">
                                                                                                         <Button icon="pi pi-pencil"
                                                                                                                        outlined
                                                                                                                        rounded
                                                                                                                        class="mr-2"
                                                                                                                        @click="editMaintenance(slotProps.data)" />
                                                                                          </template>
                                                                           </Column>
                                                            </DataTable>
                                                            <Dialog v-model:visible="maintenanceDialog" :style="{ width: '450px' }"
                                                                           :modal="true" class="p-fluid">
                                                                           <div class="field">
                                                                                          <label class="label">Mã xe</label>
                                                                                          <div class="control">
                                                                                                         <Dropdown v-model="maintenance.truck_id"
                                                                                                                        :options="truck_id_list"
                                                                                                                        optionLabel="id"
                                                                                                                        placeholder="Chọn mã xe" />
                                                                                          </div>
                                                                                          <small class="p-error"
                                                                                                         v-if="submitted && !maintenance.truck_id">Phải
                                                                                                         chọn mã xe</small>
                                                                           </div>
                                                                           <div class="p-field">
                                                                                          <label for="description">Mô tả</label>
                                                                                          <InputText id="description"
                                                                                                         v-model="maintenance.description"
                                                                                                         :class="{ 'p-invalid': submitted && !maintenance.description }"
                                                                                                         required />
                                                                                          <div v-if="submitted && !maintenance.description"
                                                                                                         class="p-invalid">Mô tả
                                                                                                         không được để trống
                                                                                          </div>
                                                                           </div>
                                                                           <div class="p-field">
                                                                                          <label for="maintenance_date">Ngày bảo
                                                                                                         trì</label>
                                                                                          <InputText id="maintenance_date"
                                                                                                         v-model="maintenance.maintenance_date"
                                                                                                         :class="{ 'p-invalid': submitted && !maintenance.maintenance_date }"
                                                                                                         required type="date" />
                                                                                          <div v-if="submitted && !maintenance.maintenance_date"
                                                                                                         class="p-invalid">Năm sản xuất
                                                                                                         không được để trống
                                                                                          </div>
                                                                           </div>
                                                                           <div class="p-field">
                                                                                          <label for="cost">Chi phí</label>
                                                                                          <InputText id="cost"
                                                                                                         v-model="maintenance.cost"
                                                                                                         :class="{ 'p-invalid': submitted && !maintenance.cost }"
                                                                                                         required type="number" />
                                                                                          <div v-if="submitted && !maintenance.cost"
                                                                                                         class="p-invalid">Chi phí
                                                                                                         không được để trống
                                                                                          </div>
                                                                           </div>
                                                                           <template #footer>
                                                                                          <Button label="Hủy" icon="pi pi-times"
                                                                                                         class="p-button-text"
                                                                                                         @click="maintenanceDialog = false" />
                                                                                          <Button label="Lưu" icon="pi pi-check"
                                                                                                         class="p-button-text"
                                                                                                         @click="saveMaintenance()" />
                                                                           </template>
                                                            </Dialog>
                                             </div>
                              </div>
               </div>
</template>
<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { FilterMatchMode } from 'primevue/api';
import { useToast } from 'primevue/usetoast';
export default {
               setup() {
                              const toast = useToast();
               },
               data() {
                              return {
                                             maintenances: null,
                                             loading: true,
                                             metaKey: true,
                                             submitted: false,
                                             maintenanceDialog: false,
                                             maintenance: {
                                                            truck_id: null,
                                                            description: null,
                                                            maintenance_date: null,
                                                            cost: null,
                                             },
                                             truck_id_list: null,
                                             filters: {
                                                            global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                                                            description: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                                            cost: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                                            maintenance_date: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                                            truck_id: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                             },
                              };
               },
               mounted() {
                              axios.get("http://127.0.0.1:8000/api/maintenances")
                                             .then(res => {
                                                            this.maintenances = res.data;
                                                            this.loading = false;
                                             })
                                             .catch(err => {
                                                            console.log(err);
                                             });
                              this.getTruck();
               },
               methods: {
                              hideDialog() {
                                             this.maintenanceDialog = false;
                                             this.submitted = false;
                              },
                              exportCSV() {
                                             this.$refs.dt.exportCSV();
                              },
                              saveMaintenance() {
                                             this.submitted = true;
                                             if (this.maintenance.description && this.maintenance.cost && this.maintenance.maintenance_date && this.maintenance.truck_id) {
                                                            this.maintenance.truck_id = this.maintenance.truck_id.id;
                                                            if (this.maintenance.id) {
                                                                           axios.put("http://127.0.0.1:8000/api/maintenances/" + this.maintenance.id, this.maintenance)
                                                                                          .then(res => {
                                                                                                         this.$toast.add({
                                                                                                                        severity: "success",
                                                                                                                        summary: "Thành công",
                                                                                                                        detail: "Cập nhật thông tin bảo dưỡng thành công",
                                                                                                                        life: 3000,
                                                                                                         });
                                                                                                         this.maintenanceDialog = false;
                                                                                                         this.maintenance = null;
                                                                                          })
                                                                                          .catch(err => {
                                                                                                         console.log(err);
                                                                                          });
                                                            }
                                                            else {
                                                                           axios.post("http://127.0.0.1:8000/api/maintenances", this.maintenance)
                                                                                          .then(res => {
                                                                                                         this.$toast.add({
                                                                                                                        severity: "success",
                                                                                                                        summary: "Thành công",
                                                                                                                        detail: "Thêm mới thông tin bảo dưỡng thành công",
                                                                                                                        life: 3000,
                                                                                                         });
                                                                                                         this.maintenanceDialog = false;
                                                                                                         this.maintenance = null;
                                                                                                         this.submitted = false;
                                                                                          })
                                                                                          .catch(err => {
                                                                                                         console.log(err);
                                                                                          });
                                                            }
                                                            this.maintenance = null;
                                                            this.maintenanceDialog = false;
                                             }
                              },
                              openNew() {
                                             this.Maintenance = {};
                                             this.submitted = false;
                                             this.maintenanceDialog = true;
                              },
                              editMaintenance(maintenance) {
                                             this.maintenance = { ...maintenance };
                                             this.maintenanceDialog = true;
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
               },
}
</script>