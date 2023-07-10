<script setup>
import { FilterMatchMode } from 'primevue/api';
import { ref, onMounted, onBeforeMount } from 'vue';
import ProductService from '@/service/ProductService';
import { useToast } from 'primevue/usetoast';



</script>
<template>
               <div class="grid">
                              <div class="col-12">
                                             <div class="card">
                                                            <DataTable :value="users" tableStyle="min-width: 50rem" stripedRows
                                                                           removableSort paginator :rows="5" filterDisplay="row"
                                                                           :rowsPerPageOptions="[5, 10, 20, 50]"
                                                                           :globalFilterFields="['name', 'phone', 'email', 'role', 'status']"
                                                                           :loading="loading" v-model:filters="filters"
                                                                           @row-edit-save="onRowEditSave" ref="dt">
                                                                           <template #header>
                                                                                          <div class="flex justify-content-end">
                                                                                                         <div style="text-align: left"
                                                                                                                        class="mr-2">
                                                                                                                        <Button icon="pi pi-external-link"
                                                                                                                                       label="Export"
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
                                                                           <Column field="name" header="Name" sortable>
                                                                                          <template #body="{ data }">
                                                                                                         {{ data.name }}
                                                                                          </template>
                                                                                          <template
                                                                                                         #filter="{ filterModel, filterCallback }">
                                                                                                         <InputText v-model="filterModel.value"
                                                                                                                        type="text"
                                                                                                                        @input="filterCallback()"
                                                                                                                        class="p-column-filter"
                                                                                                                        placeholder="Tìm theo tên" />
                                                                                          </template>
                                                                                          <template #editor="{ data, field }">
                                                                                                         <InputText
                                                                                                                        v-model="data[field]" />
                                                                                          </template>
                                                                           </Column>
                                                                           <Column field="email" header="Email" sortable>
                                                                                          <template #body="{ data }">
                                                                                                         {{ data.email }}
                                                                                          </template>
                                                                                          <template
                                                                                                         #filter="{ filterModel, filterCallback }">
                                                                                                         <InputText v-model="filterModel.value"
                                                                                                                        type="text"
                                                                                                                        @input="filterCallback()"
                                                                                                                        class="p-column-filter"
                                                                                                                        placeholder="Tìm theo email" />
                                                                                          </template>
                                                                           </Column>
                                                                           <Column field="phone" header="Phone" sortable>
                                                                                          <template #body="{ data }">
                                                                                                         {{ data.phone }}
                                                                                          </template>
                                                                                          <template
                                                                                                         #filter="{ filterModel, filterCallback }">
                                                                                                         <InputText v-model="filterModel.value"
                                                                                                                        type="text"
                                                                                                                        @input="filterCallback()"
                                                                                                                        class="p-column-filter"
                                                                                                                        placeholder="Tìm theo số điện thoại" />
                                                                                          </template>
                                                                           </Column>
                                                                           <Column field="role" header="Role" sortable>
                                                                                          <template #body="{ data }">
                                                                                                         {{ data.role }}
                                                                                          </template>
                                                                                          <template
                                                                                                         #filter="{ filterModel, filterCallback }">
                                                                                                         <InputText v-model="filterModel.value"
                                                                                                                        type="text"
                                                                                                                        @input="filterCallback()"
                                                                                                                        class="p-column-filter"
                                                                                                                        placeholder="Tìm theo loại người dùng" />
                                                                                          </template>

                                                                           </Column>
                                                                           <Column field="status" header="Status" sortable>
                                                                                          <template #body="{ data }">
                                                                                                         <Badge
                                                                                                                        :severity="getSeverity(data)">
                                                                                                                        {{ data.status
                                                                                                                        }}
                                                                                                         </Badge>
                                                                                          </template>
                                                                                          <template
                                                                                                         #filter="{ filterModel, filterCallback }">
                                                                                                         <InputText v-model="filterModel.value"
                                                                                                                        type="text"
                                                                                                                        @input="filterCallback()"
                                                                                                                        class="p-column-filter"
                                                                                                                        placeholder="Tìm theo trạng thái" />
                                                                                          </template>
                                                                           </Column>
                                                                           <Column :rowEditor="true"
                                                                                          style="width: 10%; min-width: 8rem"
                                                                                          bodyStyle="text-align:center"></Column>
                                                            </DataTable>
                                             </div>
                              </div>
               </div>
</template>
<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
               data() {
                              return {
                                             users: null,
                                             loading: true,
                                             filters: {
                                                            global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                                                            name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                                            email: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                                            phone: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                                            role: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                                                            status: { value: null, matchMode: FilterMatchMode.STARTS_WITH }
                                             },
                                             statuses: [
                                                            { label: 'Active', value: 'active' },
                                                            { label: 'Inactive', value: 'inactive' },
                                             ]
                              };
               },
               // lấy dữ liệu từ api về và đẩy vào table 
               mounted() {
                              axios.get("http://127.0.0.1:8000/api/users")
                                             .then(res => {
                                                            this.users = res.data;
                                                            this.loading = false;

                                             })
                                             .catch(err => {
                                                            console.log(err);
                                             });
               },
               methods: {
                              getSeverity(user) {
                                             switch (user.status) {
                                                            case 'active':
                                                                           return 'success';

                                                            case 'inactive':
                                                                           return 'warning';

                                                            default:
                                                                           return null;
                                             }
                              },
                              onRowEditSave(e) {
                                             const data = e.data;
                                             axios.put(`http://127.0.0.1:8000/api/users/${data.id}`, data)
                                                            .then(res => {
                                                                           this.$toast.add({
                                                                                          severity: 'success',
                                                                                          summary: 'Successful',
                                                                                          detail: 'User Updated',
                                                                                          life: 3000
                                                                           });
                                                            })
                                                            .catch(err => {
                                                                           console.log(err);
                                                                           this.$toast.add({
                                                                                          severity: 'error',
                                                                                          summary: 'Error',
                                                                                          detail: 'User Update Failed',
                                                                                          life: 3000
                                                                           });
                                                            });
                              },
                              exportCSV() {
                                             this.$refs.dt.exportCSV();
                              }

               }
}
</script>