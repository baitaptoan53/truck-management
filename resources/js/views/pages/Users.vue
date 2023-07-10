<script setup>
import { FilterMatchMode } from 'primevue/api';
import { ref, onMounted, onBeforeMount } from 'vue';
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
                                                                           @row-edit-save="onRowEditSave" ref="dt"
                                                                           v-model:selection="selectedUsers" dataKey="id">
                                                                           <template #header>
                                                                                          <div class="flex justify-content-end">
                                                                                                         <div style="text-align: left"
                                                                                                                        class="mr-2">
                                                                                                                        <Button icon="pi pi-plus"
                                                                                                                                       label="Thêm mới"
                                                                                                                                       @click="onAddNewUser"
                                                                                                                                       severity="success" />
                                                                                                         </div>
                                                                                                         <!-- delete -->
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
                                                                           <Column selectionMode="multiple" headerStyle="width: 3rem">
                                                                           </Column>
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
                                                                           <Column :exportable="false" style="min-width:9rem">
                                                                                          <template #body="slotProps">
                                                                                                         <Button icon="pi pi-pencil"
                                                                                                                        outlined
                                                                                                                        rounded
                                                                                                                        class="mr-2"
                                                                                                                        @click="editUser(slotProps.data)" />
                                                                                                         <Button icon="pi pi-trash"
                                                                                                                        outlined
                                                                                                                        rounded
                                                                                                                        severity="danger"
                                                                                                                        @click="confirmDeleteUser(slotProps.data)" />
                                                                                          </template>
                                                                           </Column>

                                                            </DataTable>

                                                            <Dialog v-model:visible="deleteUserDialog" :style="{ width: '450px' }"
                                                                           header="Confirm" :modal="true">
                                                                           <div class="confirmation-content">
                                                                                          <i class="pi pi-exclamation-triangle mr-3"
                                                                                                         style="font-size: 2rem" />
                                                                                          <span v-if="user">Bạn muốn xóa người dùng
                                                                                                         <b>{{ user.name }}</b>?</span>
                                                                           </div>
                                                                           <template #footer>
                                                                                          <Button label="No" icon="pi pi-times" text
                                                                                                         @click="deleteUserDialog = false" />
                                                                                          <Button label="Yes" icon="pi pi-check" text
                                                                                                         @click="deleteUser" />
                                                                           </template>
                                                            </Dialog>
                                                            <Dialog v-model:visible="deleteUsersDialog" :style="{ width: '450px' }"
                                                                           header="Confirm" :modal="true">
                                                                           <div class="confirmation-content">
                                                                                          <i class="pi pi-exclamation-triangle mr-3"
                                                                                                         style="font-size: 2rem" />
                                                                                          <span v-if="user">Bạn muốn xóa những người
                                                                                                         dùng này</span>
                                                                           </div>
                                                                           <template #footer>
                                                                                          <Button label="No" icon="pi pi-times" text
                                                                                                         @click="deleteUsersDialog = false" />
                                                                                          <Button label="Yes" icon="pi pi-check" text
                                                                                                         @click="deleteSelectedUsers" />
                                                                           </template>
                                                            </Dialog>
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
                                             metaKey: true,
                                             selectedUser: null,
                                             selectedUsers: null,
                                             deleteUserDialog: false,
                                             deleteUsersDialog: false,
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
                              },
                              confirmDeleteUser(user) {
                                             this.user = user;
                                             this.deleteUserDialog = true;
                              },
                              deleteUser() {
                                             axios.delete(`http://127.0.0.1:8000/api/users/${this.user.id}`)
                                                            .then(res => {
                                                                           this.users = this.users.filter(val => val.id !== this.user.id);
                                                                           this.deleteUserDialog = false;
                                                                           this.user = null;
                                                                           this.$toast.add({
                                                                                          severity: 'success',
                                                                                          summary: 'Successful',
                                                                                          detail: 'User Deleted',
                                                                                          life: 3000
                                                                           });
                                                            })
                                                            .catch(err => {
                                                                           console.log(err);
                                                                           this.$toast.add({
                                                                                          severity: 'error',
                                                                                          summary: 'Error',
                                                                                          detail: 'User Delete Failed',
                                                                                          life: 3000
                                                                           });
                                                            });
                              },
                              deleteSelectedUsers() {
                                             let users = this.selectedUsers;
                                             this.deleteUsersDialog = false;
                                             users.forEach(user => {
                                                            axios.delete(`http://127.0.0.1:8000/api/users/${user.id}`)
                                                                           .then(res => {
                                                                                          this.users = this.users.filter(val => val.id !== user.id);
                                                                                          this.selectedUsers = null;
                                                                                          this.$toast.add({
                                                                                                         severity: 'success',
                                                                                                         summary: 'Successful',
                                                                                                         detail: 'Users Deleted',
                                                                                                         life: 3000
                                                                                          });
                                                                           })
                                                                           .catch(err => {
                                                                                          console.log(err);
                                                                                          this.$toast.add({
                                                                                                         severity: 'error',
                                                                                                         summary: 'Error',
                                                                                                         detail: 'Users Delete Failed',
                                                                                                         life: 3000
                                                                                          });
                                                                           });
                                             });
                              },
                              confirmDeleteSelected() {
                                             this.deleteUsersDialog = true;
                              },





               }
}
</script>