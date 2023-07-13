<template>
               <div class="p-grid">
                              <div class="p-col-12">
                                             <div class="card">
                                                            <h1>Chuyến xe

                                                            </h1>

                                                            <DataTable :value="trips" tableStyle="min-width: 50rem" stripedRows
                                                                           removableSort paginator :rows="5" filterDisplay="row"
                                                                           :rowsPerPageOptions="[5, 10, 20, 50]" :loading="loading"
                                                                           v-model:filters="filters" @row-edit-save="onRowEditSave"
                                                                           ref="dt" v-model:selection="selectedUsers" dataKey="id">
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
                                                                           <template #empty> No customers found. </template>
                                                                           <template #loading> Loading customers data. Please
                                                                                          wait.</template>
                                                                           <column field="start_date" header="Ngày đi" sortable>
                                                                                          <template #body="{ data }">
                                                                                                         {{ data.start_date }}
                                                                                          </template>
                                                                                          <template
                                                                                                         #filter="{ filterModel, filterCallback }">
                                                                                                         <InputText v-model="filterModel.value"
                                                                                                                        type="text"
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
                                                                                                                        type="text"
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
                                                                           <column field="total_amount" header="Khoảng cách" sortable>
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

                                                            </DataTable>
                                                            
                                             </div>
                              </div>
               </div>
</template>
<script>
import { ref, onMounted } from 'vue';
import { FilterMatchMode } from 'primevue/api';
import axios from 'axios';
export default {
               data() {
                              return {
                                             trips: null,
                                             loading: true,
                                             columns: null,
                                             tripDialog: true,
                                             submitted: false,
                                             filters: {
                                                            global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                                                            start_date: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                                            end_date: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                                            start_location: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                                            end_location: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                                            total_distance: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                                            total_amount: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                             }
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
               },
}
</script>