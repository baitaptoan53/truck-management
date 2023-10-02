<template>
    <Toast/>
    <div class="p-grid">
        <div class="p-col-12">
            <div class="card">
                <DataTable :value="trucks" tableStyle="min-width: 50rem"
                           :rowsPerPageOptions="[5, 10, 20, 50]" stripedRows
                           removableSort paginator :rows="5" filterDisplay="row"
                           :loading="loading" v-model:filters="filters" dataKey="id"
                           :globalFilterFields="['manufacturer', 'model', 'year', 'license_plate', 'vin_number', 'registration_date', 'curent_mileage']"
                           v-model:selection="selectedTrucks" ref="dt"
                           @row-edit-save="onRowEditSave" @row-select="onRowSelect">
                    <template #header>
                        <div class="flex justify-content-end">
                            <div style="text-align: left"
                                 class="mr-2">
                                <Button icon="pi pi-plus"
                                        label="Thêm mới"
                                        @click="openNew"
                                        severity="success"/>
                            </div>
                            <div style="text-align: left"
                                 class="mr-2">
                                <Button icon="pi pi-trash"
                                        label="Xóa"
                                        @click="confirmDeleteSelected"
                                        :disabled="!selectedTrucks || !selectedTrucks.length"
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
                                                                                                                            placeholder="Từ khóa"/>
                                                                                                         </span>
                        </div>
                    </template>
                    <template #empty> Không có xe nào</template>
                    <template #loading>
                        <ProgressSpinner/>
                        Đang tải dữ liệu xe...
                    </template>
                    <Column selectionMode="multiple" headerStyle="width: 3rem">
                    </Column>
                    <Column field="manufacturer" header="Hãng xe" sortable>
                        <template #body="{ data }">
                            {{ data.manufacturer }}
                        </template>
                        <template
                            #filter="{ filterModel, filterCallback }">
                            <InputText v-model="filterModel.value"
                                       type="text"
                                       @input="filterCallback()"
                                       class="p-column-filter"
                                       placeholder="Tìm hãng xe"/>
                        </template>
                    </Column>
                    <Column field="model" header="Nhãn hiệu" sortable>
                        <template #body="{ data }">
                            {{ data.model }}
                        </template>
                        <template
                            #filter="{ filterModel, filterCallback }">
                            <InputText v-model="filterModel.value"
                                       type="text"
                                       @input="filterCallback()"
                                       class="p-column-filter"
                                       placeholder="Tìm model"/>
                        </template>
                    </Column>
                    <Column field="year" header="Năm sản xuất" sortable>
                        <template #body="{ data }">
                            {{ data.year }}
                        </template>
                        <template
                            #filter="{ filterModel, filterCallback }">
                            <InputText v-model="filterModel.value"
                                       type="text"
                                       @input="filterCallback()"
                                       class="p-column-filter"
                                       placeholder="Tìm năm sản xuất"/>
                        </template>
                    </Column>
                    <Column field="license_plate" header="Biển số xe" sortable>
                        <template #body="{ data }">
                            {{ data.license_plate }}
                        </template>
                        <template
                            #filter="{ filterModel, filterCallback }">
                            <InputText v-model="filterModel.value"
                                       type="text"
                                       @input="filterCallback()"
                                       class="p-column-filter"
                                       placeholder="Tìm biển số xe"/>
                        </template>
                    </Column>
                    <Column field="vin_number" header="Số khung" sortable>
                        <template #body="{ data }">
                            {{ data.vin_number }}
                        </template>
                        <template
                            #filter="{ filterModel, filterCallback }">
                            <InputText v-model="filterModel.value"
                                       type="text"
                                       @input="filterCallback()"
                                       class="p-column-filter"
                                       placeholder="Tìm số khung"/>
                        </template>
                    </Column>
                    <Column field="registration_date" header="Ngày đăng ký"
                            sortable>
                        <template #body="{ data }">
                            {{ data.registration_date }}
                        </template>
                        <template
                            #filter="{ filterModel, filterCallback }">
                            <InputText v-model="filterModel.value"
                                       type="text"
                                       @input="filterCallback()"
                                       class="p-column-filter"
                                       placeholder="Tìm ngày đăng ký"/>
                        </template>
                    </Column>
                    <Column field="curent_mileage" header="Số km hiện tại"
                            sortable>
                        <template #body="{ data }">
                            {{ data.curent_mileage }}
                        </template>
                        <template
                            #filter="{ filterModel, filterCallback }">
                            <InputText v-model="filterModel.value"
                                       type="text"
                                       @input="filterCallback()"
                                       class="p-column-filter"
                                       placeholder="Tìm số km hiện tại"/>
                        </template>
                    </Column>
                    <Column :exportable="false" style="min-width:9rem">
                        <template #body="slotProps">
                            <Button icon="pi pi-pencil"
                                    outlined
                                    rounded
                                    class="mr-2"
                                    @click="editTruck(slotProps.data)"/>
                            <Button icon="pi pi-trash"
                                    outlined
                                    rounded
                                    severity="danger"
                                    @click="confirmDeleteTruck(slotProps.data)"/>
                        </template>
                    </Column>
                </DataTable>
                <Dialog v-model:visible="truckDialog" :style="{ width: '450px' }"
                        header="Chỉnh sủa xe" :modal="true" class="p-fluid">
                    <div class="p-field">
                        <label for="manufacturer">Hãng xe</label>
                        <InputText id="manufacturer"
                                   v-model="truck.manufacturer"
                                   :class="{ 'p-invalid': submitted && !truck.manufacturer }"
                                   required autofocus/>
                        <div v-if="submitted && !truck.manufacturer"
                             class="p-invalid">Hãng xe
                            không được để trống
                        </div>
                    </div>
                    <div class="p-field">
                        <label for="model">Nhãn hiệu</label>
                        <InputText id="model" v-model="truck.model"
                                   :class="{ 'p-invalid': submitted && !truck.model }"
                                   required/>
                        <div v-if="submitted && !truck.model"
                             class="p-invalid">Nhãn hiệu
                            không được để trống
                        </div>
                    </div>
                    <div class="p-field">
                        <label for="year">Năm sản xuất</label>
                        <InputText id="year" v-model="truck.year"
                                   :class="{ 'p-invalid': submitted && !truck.year }"
                                   required/>
                        <div v-if="submitted && !truck.year"
                             class="p-invalid">Năm sản xuất
                            không được để trống
                        </div>
                    </div>
                    <div class="p-field">
                        <label for="license_plate">Biển số xe</label>
                        <InputText id="license_plate"
                                   v-model="truck.license_plate"
                                   :class="{ 'p-invalid': submitted && !truck.license_plate }"
                                   required/>
                        <div v-if="submitted && !truck.license_plate"
                             class="p-invalid">Biển số xe
                            không được để trống
                        </div>
                    </div>
                    <div class="p-field">
                        <label for="vin_number">Số khung</label>
                        <InputText id="vin_number"
                                   v-model="truck.vin_number"
                                   :class="{ 'p-invalid': submitted && !truck.vin_number }"
                                   required/>
                        <div v-if="submitted && !truck.vin_number"
                             class="p-invalid">Số khung
                            không được để trống
                        </div>
                    </div>
                    <div class="p-field">
                        <label for="purchase_date">Ngày mua
                            xe</label>
                        <Calendar id="purchase_date"
                                  dateFormat="dd-mm-yy"
                                  v-model="truck.purchase_date"
                                  :class="{ 'p-invalid': submitted && !truck.purchase_date }"
                                  required showIcon/>
                        <div v-if="submitted && !truck.purchase_date"
                             class="p-invalid">Ngày mua xe
                        </div>
                    </div>
                    <div class="p-field">
                        <label for="registration_date">Ngày đăng
                            ký</label>
                        <Calendar id="registration_date"
                                  dateFormat="dd-mm-yy"
                                  v-model="truck.registration_date"
                                  :class="{ 'p-invalid': submitted && !truck.registration_date }"
                                  required showIcon/>
                        <div v-if="submitted && !truck.registration_date"
                             class="p-invalid">Ngày đăng ký
                            không được để trống
                        </div>
                    </div>
                    <div class="p-field">
                        <label for="curent_mileage">Số km hiện
                            tại</label>
                        <InputText id="curent_mileage"
                                   v-model="truck.curent_mileage"
                                   :class="{ 'p-invalid': submitted && !truck.curent_mileage }"
                                   required/>
                        <div v-if="submitted && !truck.curent_mileage"
                             class="p-invalid">Số km hiện
                            tại không được để trống
                        </div>
                    </div>
                    <template #footer>
                        <Button label="Hủy" icon="pi pi-times"
                                class="p-button-text"
                                @click="truckDialog = false"/>
                        <Button label="Lưu" icon="pi pi-check"
                                class="p-button-text"
                                @click="saveTruck()"/>
                    </template>

                </Dialog>
                <Dialog v-model:visible="deleteTruckDialog" modal header="Xóa xe"
                        :style="{ width: '450px' }">
                    <div class="confirmation-content">
                        <i class="pi pi-exclamation-triangle p-mr-3"
                           style="font-size: 2rem;color: #f44336"></i>
                        <span v-if="truck">Bạn có chắc chắn muốn xóa
                                                                                                         xe có biển số <b>{{
                                    truck.license_plate
                                }}</b>?</span>
                    </div>
                    <template #footer>
                        <Button label="Hủy" icon="pi pi-times"
                                class="p-button-text"
                                @click="deleteTruckDialog = false"/>
                        <Button label="Xóa" icon="pi pi-check"
                                class="p-button-text"
                                @click="deleteTruck"/>
                    </template>
                </Dialog>
                <Dialog v-model:visible="deleteTrucksDialog" modal header="Xóa xe"
                        :style="{ width: '450px' }">
                    <div class="confirmation-content">
                        <i class="pi pi-exclamation-triangle p-mr-3"
                           style="font-size: 2rem;color: #f44336"></i>
                        <span>Bạn có chắc chắn muốn xóa
                                                                                                         những xe đã
                                                                                                         chọn?</span>
                    </div>
                    <template #footer>
                        <Button label="Hủy" icon="pi pi-times"
                                class="p-button-text"
                                @click="deleteTrucksDialog = false"/>
                        <Button label="Xóa" icon="pi pi-check"
                                class="p-button-text"
                                @click="deleteSelectedTrucks"/>
                    </template>
                </Dialog>
            </div>
        </div>
    </div>
</template>
<script>
import {ref, onMounted} from 'vue';
import axios from 'axios';
import {FilterMatchMode} from 'primevue/api';
import {useToast} from 'primevue/usetoast';

export default {
    setup() {
        const toast = useToast();
    },
    data() {
        return {
            trucks: null,
            loading: true,
            metaKey: true,
            selectedTruck: null,
            selectedTrucks: null,
            deleteTruckDialog: false,
            deleteTrucksDialog: false,
            submitted: false,
            truckDialog: false,
            truck: {
                id: null,
                manufacturer: null,
                model: null,
                year: null,
                license_plate: null,
                vin_number: null,
                purchase_date: null,
                registration_date: null,
                curent_mileage: null,
            },
            filters: {
                global: {value: null, matchMode: FilterMatchMode.CONTAINS},
                manufacturer: {value: null, matchMode: FilterMatchMode.STARTS_WITH},
                model: {value: null, matchMode: FilterMatchMode.STARTS_WITH},
                year: {value: null, matchMode: FilterMatchMode.STARTS_WITH},
                license_plate: {value: null, matchMode: FilterMatchMode.STARTS_WITH},
                vin_number: {value: null, matchMode: FilterMatchMode.STARTS_WITH},
                registration_date: {value: null, matchMode: FilterMatchMode.STARTS_WITH},
                curent_mileage: {value: null, matchMode: FilterMatchMode.STARTS_WITH},

            },
        };
    },
    mounted() {
        axios.get("http://127.0.0.1:8000/api/trucks")
            .then(res => {
                this.trucks = res.data;
                this.loading = false;

            })
            .catch(err => {
                console.log(err);
            });
    },
    methods: {

        hideDialog() {
            this.truckDialog = false;
            this.submitted = false;
        },
        confirmDeleteTruck(truck) {
            this.truck = truck;
            this.deleteTruckDialog = true;
        },
        deleteTruck() {
            axios.delete(`http://127.0.0.1:8000/api/trucks/${this.truck.id}`)
                .then(res => {
                    this.trucks = this.trucks.filter(val => val.id !== this.truck.id);
                    this.deleteTruckDialog = false;
                    this.truck = {};
                    this.$toast.add({
                        severity: "success",
                        summary: "Thành công",
                        detail: "Xóa xe thành công",
                        life: 3000,
                    });
                })
                .catch(err => {
                    console.log(err);
                    this.$toast.add({
                        severity: "error",
                        summary: "Thất bại",
                        detail: "Xóa xe thất bại",
                        life: 3000,
                    });
                });
        },
        exportCSV() {
            this.$refs.dt.exportCSV();
        },
        confirmDeleteSelected() {
            this.deleteTrucksDialog = true;
        },
        deleteSelectedTrucks() {
            let trucks = this.selectedTrucks;
            this.deleteTrucksDialog = false;
            trucks.forEach(truck => {
                axios.delete(`http://127.0.0.1:8000/api/trucks/${truck.id}`)
                    .then(res => {
                        this.trucks = this.trucks.filter(val => val.id !== truck.id);
                        this.selectedTrucks = null;
                        this.$toast.add({
                            severity: "success",
                            summary: "Thành công",
                            detail: "Xóa xe thành công",
                            life: 3000,
                        });
                    })
                    .catch(err => {
                        console.log(err);
                        this.$toast.add({
                            severity: "error",
                            summary: "Thất bại",
                            detail: "Xóa xe thất bại",
                            life: 3000,
                        });
                    });
            });
        },
        saveTruck() {
            this.submitted = true;
            if (this.truck.manufacturer.trim()) {
                if (this.truck.id) {
                    axios.put(`http://127.0.0.1:8000/api/trucks/${this.truck.id}`, this.truck)
                        .then(res => {
                            this.$toast.add({
                                severity: "success",
                                summary: "Thành công",
                                detail: "Cập nhật xe thành công",
                                life: 3000,
                            });
                            this.truckDialog = false;
                            this.truck = {};
                            this.submitted = false;
                        })
                        .catch(err => {
                            console.log(err);
                            this.$toast.add({
                                severity: "error",
                                summary: "Thất bại",
                                detail: "Cập nhật xe thất bại",
                                life: 3000,
                            });
                        });
                } else {
                    this.truck.purchase_date = this.truck.purchase_date.toISOString().slice(0, 10);
                    this.truck.registration_date = this.truck.registration_date.toISOString().slice(0, 10);
                    axios.post("http://127.0.0.1:8000/api/trucks", this.truck)
                        .then(res => {
                            this.$toast.add({
                                severity: "success",
                                summary: "Thành công",
                                detail: "Thêm xe thành công",
                                life: 3000,
                            });
                            this.truckDialog = false;
                            this.truck = {};
                            this.submitted = false;
                        })
                        .catch(err => {
                            console.log(err);
                            this.$toast.add({
                                severity: "error",
                                summary: "Thất bại",
                                detail: "Thêm xe thất bại",
                                life: 3000,
                            });
                        });
                }
                this.user = null;
                this.userDialog = false;
            }
        },
        openNew() {
            this.truck = {};
            this.submitted = false;
            this.truckDialog = true;
        },
        onRowSelect(event) {
            this.$toast.add({
                severity: "info",
                summary: "Xe đã được chọn",
                detail: "Biển số xe: " + event.data.license_plate,
                life: 3000,
            });
        },
        editTruck(truck) {
            this.truck = {...truck};
            this.truckDialog = true;
        },

    },
}
</script>
