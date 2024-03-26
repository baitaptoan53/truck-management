<script setup>
import {FilterMatchMode} from 'primevue/api';
</script>
<template>
    <Toast/>
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
                            <!-- <div style="text-align: left"
                                           class="mr-2">
                                           <Button icon="pi pi-plus"
                                                          label="Thêm mới"
                                                          @click="openNew"
                                                          severity="success" />
                            </div> -->
                            <div style="text-align: left"
                                 class="mr-2">
                                <Button icon="pi pi-trash"
                                        label="Xóa"
                                        @click="confirmDeleteSelected"
                                        :disabled="!selectedUsers || !selectedUsers.length"
                                        class="p-button-danger"/>
                            </div>
                            <div style="text-align: left"
                                 class="mr-2">
                                <Button icon="pi pi-external-link"
                                        label="Tải tệp CSV"
                                        @click="exportCSV($event)"/>
                            </div>
                            <span
                                class="p-input-icon-left">
                                                                                                                        <i
                                                                                                                            class="pi pi-search"/>
                                                                                                                        <InputText
                                                                                                                            v-model="filters['global'].value"
                                                                                                                            placeholder="Keyword Search"/>
                                                                                                         </span>
                        </div>
                    </template>
                    <template #empty> Không tìm thấy người dùng.</template>
                    <template #loading>
                        <ProgressSpinner/>
                        Đang tải dữ liệu người
                        dùng...
                    </template>
                    <Column selectionMode="multiple" headerStyle="width: 3rem">
                    </Column>
                    <Column field="name" header="Họ và tên" sortable>
                        <template #body="{ data }">
                            {{ data.name }}
                        </template>
                        <template
                            #filter="{ filterModel, filterCallback }">
                            <InputText v-model="filterModel.value"
                                       type="text"
                                       @input="filterCallback()"
                                       class="p-column-filter"
                                       placeholder="Tìm theo tên"/>
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
                                       placeholder="Tìm theo email"/>
                        </template>
                    </Column>
                    <Column field="phone" header="SĐT" sortable>
                        <template #body="{ data }">
                            {{ data.phone }}
                        </template>
                        <template
                            #filter="{ filterModel, filterCallback }">
                            <InputText v-model="filterModel.value"
                                       type="text"
                                       @input="filterCallback()"
                                       class="p-column-filter"
                                       placeholder="Tìm theo số điện thoại"/>
                        </template>
                    </Column>
                    <Column field="role" header="Vai trò" sortable>
                        <template #body="{ data }">
                            {{ data.role }}
                        </template>
                        <template
                            #filter="{ filterModel, filterCallback }">
                            <InputText v-model="filterModel.value"
                                       type="text"
                                       @input="filterCallback()"
                                       class="p-column-filter"
                                       placeholder="Tìm theo loại người dùng"/>
                        </template>

                    </Column>
                    <Column field="status" header="Trạng thái" sortable>
                        <template #body="{ data }">
                            <Badge
                                :severity="getSeverity(data)">
                                {{
                                    data.status
                                }}
                            </Badge>
                        </template>
                        <template
                            #filter="{ filterModel, filterCallback }">
                            <InputText v-model="filterModel.value"
                                       type="text"
                                       @input="filterCallback()"
                                       class="p-column-filter"
                                       placeholder="Tìm theo trạng thái"/>
                        </template>
                    </Column>
                    <Column :exportable="false" style="min-width:9rem">
                        <template #body="slotProps">
                            <Button icon="pi pi-pencil"
                                    outlined
                                    rounded
                                    class="mr-2"
                                    @click="editUser(slotProps.data)"/>
                            <Button icon="pi pi-trash"
                                    outlined
                                    rounded
                                    severity="danger"
                                    @click="confirmDeleteUser(slotProps.data)"/>
                        </template>
                    </Column>

                </DataTable>
                <Dialog v-model:visible="userDialog" :style="{ width: '450px' }"
                        header="Chỉnh sủa tên người dùng" :modal="true"
                        class="p-fluid">
                    <div class="field">
                        <label for="name">Tên người dùng</label>
                        <InputText id="name" v-model.trim="user.name"
                                   required="true" autofocus
                                   :class="{ 'p-invalid': submitted && !user.name }"/>
                        <small class="p-error"
                               v-if="submitted && !user.name">Phải
                            điền tên</small>
                    </div>
                    <div class="field">
                        <label for="phone">Số điện thoại</label>
                        <InputText id="phone"
                                   v-model.trim="user.phone"
                                   required="true"
                                   :class="{ 'p-invalid': submitted && !user.phone }"/>
                        <small class="p-error"
                               v-if="submitted && !user.phone">Phải
                            điền số điện thoại</small>
                    </div>
                    <div class="field">
                        <label for="email">Email</label>
                        <InputText id="email"
                                   v-model.trim="user.email"
                                   required="true"
                                   :class="{ 'p-invalid': submitted && !user.email }"/>
                        <small class="p-error"
                               v-if="submitted && !user.email">Phải
                            điền Email</small>
                    </div>
                    <div class="field">
                        <label for="status" class="mb-3">Trạng
                            thái</label>
                        <Dropdown id="status" v-model="user.status"
                                  :options="statuses"
                                  optionLabel="label"
                                  placeholder="Chọn trạng thái">
                            <template #value="slotProps">
                                <div
                                    v-if="slotProps.value && slotProps.value.value">
                                    <Tag :value="slotProps.value.value"
                                         :severity="getSeverity(slotProps.value.label)"/>
                                </div>
                                <div
                                    v-else-if="slotProps.value && !slotProps.value.value">
                                    <Tag :value="slotProps.value"
                                         :severity="getSeverity(slotProps.value)"/>
                                </div>
                                <span v-else>
                                                                                                                                       {{
                                        slotProps.placeholder
                                    }}
                                                                                                                        </span>
                            </template>
                        </Dropdown>
                    </div>
                    <template #footer>
                        <Button label="Hủy" icon="pi pi-times" text
                                @click="hideDialog"/>
                        <Button label="Lưu" icon="pi pi-check" text
                                @click="saveUser"/>
                    </template>
                </Dialog>

                <Dialog v-model:visible="deleteUserDialog" :style="{ width: '450px' }"
                        header="Confirm" :modal="true">
                    <div class="confirmation-content">
                        <i class="pi pi-exclamation-triangle mr-3"
                           style="font-size: 2rem"/>
                        <span v-if="user">Bạn muốn xóa người dùng
                                                                                                         <b>{{
                                                                                                                 user.name
                                                                                                             }}</b>?</span>
                    </div>
                    <template #footer>
                        <Button label="Hủy" icon="pi pi-times" text
                                @click="deleteUserDialog = false"/>
                        <Button label="Xóa" icon="pi pi-check" text
                                @click="deleteUser"/>
                    </template>
                </Dialog>
                <Dialog v-model:visible="deleteUsersDialog" :style="{ width: '450px' }"
                        header="Confirm" :modal="true">
                    <div class="confirmation-content">
                        <i class="pi pi-exclamation-triangle mr-3"
                           style="font-size: 2rem"/>
                        <span>Bạn muốn xóa những người
                                                                                                         dùng này</span>
                    </div>
                    <template #footer>
                        <Button label="Hủy" icon="pi pi-times" text
                                @click="deleteUsersDialog = false"/>
                        <Button label="Xóa" icon="pi pi-check" text
                                @click="deleteSelectedUsers"/>
                    </template>
                </Dialog>
            </div>
        </div>
    </div>
</template>
<script>
import {ref, onMounted} from 'vue';
import axios from 'axios';
import Toast from 'primevue/toast';
import {useToast} from 'primevue/usetoast';

export default {
    setup() {
        const toast = useToast();
    },
    data() {
        return {
            users: null,
            loading: true,
            metaKey: true,
            selectedUser: null,
            selectedUsers: null,
            deleteUserDialog: false,
            deleteUsersDialog: false,
            submitted: false,
            userDialog: false,
            filters: {
                global: {value: null, matchMode: FilterMatchMode.CONTAINS},
                name: {value: null, matchMode: FilterMatchMode.STARTS_WITH},
                email: {value: null, matchMode: FilterMatchMode.STARTS_WITH},
                phone: {value: null, matchMode: FilterMatchMode.STARTS_WITH},
                role: {value: null, matchMode: FilterMatchMode.STARTS_WITH},
                status: {value: null, matchMode: FilterMatchMode.STARTS_WITH}
            },
            statuses: [
                {label: 'Active', value: 'active'},
                {label: 'Inactive', value: 'inactive'},
            ]
        };
    },
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
                // thông báo ra toast
                .then(res => {
                    this.$toast.add({
                        severity: 'success',
                        summary: 'Xong',
                        detail: 'Cập nhật thành công',
                        life: 3000
                    });
                })
                .catch(err => {
                    console.log(err);
                    this.$toast.add({
                        severity: 'error',
                        summary: 'Lỗi',
                        detail: 'Cập nhật thất bại',
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
                        summary: 'Xong',
                        detail: 'Xóa người dùng thành công',
                        life: 3000
                    });
                })
                .catch(err => {
                    console.log(err);
                    this.$toast.add({
                        severity: 'error',
                        summary: 'Lỗi',
                        detail: 'Xóa người dùng thất bại',
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
                            detail: 'Xóa người dùng thành công',
                            life: 3000
                        });
                    })
                    .catch(err => {
                        console.log(err);
                        this.$toast.add({
                            severity: 'error',
                            summary: 'Error',
                            detail: 'Xóa người dùng thất bại',
                            life: 3000
                        });
                    });
            });
        },
        confirmDeleteSelected() {
            this.deleteUsersDialog = true;
        },
        hideDialog() {
            this.userDialog = false;
            this.submitted = false;
        },
        saveUser() {
            this.submitted = true;
            if (this.user.name.trim()) {
                if (this.user.id) {
                    axios.put(`http://127.0.0.1:8000/api/users/${this.user.id}`, this.user)
                        .then(res => {
                            let index = this.users.findIndex(user => user.id === this.user.id);
                            this.users.splice(index, 1, res.data);
                            this.$toast.add({
                                severity: "success",
                                summary: "Thành công",
                                detail: "Cập nhật người dùng thành công",
                                life: 3000,
                            });
                            this.userDialog = false;
                            this.user = {};
                            this.submitted = false;
                        })
                        .catch(err => {
                            console.log(err);
                            this.$toast.add({
                                severity: "error",
                                summary: "Thất bại",
                                detail: "Cập nhật người dùng thất bại",
                                life: 3000,
                            });
                        });
                }
                // else {
                //                axios.post('http://127.0.0.1:8000/api/users', this.user)
                //                               .then(res => {
                //                                              this.$toast.add({
                //                                                             severity: 'success',
                //                                                             summary: 'Successful',
                //                                                             detail: 'User Created',
                //                                                             life: 3000
                //                                              });
                //                               })
                //                               .catch(err => {
                //                                              console.log(err);
                //                                              this.$toast.add({
                //                                                             severity: 'error',
                //                                                             summary: 'Error',
                //                                                             detail: 'User Creation Failed',
                //                                                             life: 3000
                //                                              });
                //                               });
                // }
                this.user = null;
                this.userDialog = false;
            }
        },
        editUser(user) {
            this.user = {...user};
            this.userDialog = true;
        },
        // openNew() {
        //                this.user = {};
        //                this.submitted = false;
        //                this.userDialog = true;
        // },

    }
}
</script>
