<template>
    <Toast/>
    <div class="p-grid">
        <div class="p-col-12">
            <div class="card">
                <DataTable :value="places" tableStyle="min-width: 50rem"
                           :rowsPerPageOptions="[5, 10, 20, 50]" stripedRows
                           removableSort paginator :rows="5" filterDisplay="row"
                           :loading="loading" v-model:filters="filters" dataKey="id"
                           :globalFilterFields="['name','description','address']"
                           v-model:selection="selectedPlaces" ref="dt"
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
                                        :disabled="!selectedPlaces || !selectedPlaces.length"
                                        class="p-button-danger"/>
                            </div>
                            <div style="text-align: left"
                                 class="mr-2">
                                <Button icon="pi pi-external-link"
                                        label="Tải tệp CSV"
                                        @click="exportCSV($event)"/>
                            </div>
                            <span class="p-input-icon-left">
                                    <i class="pi pi-search"/>
                                <InputText v-model="filters['global'].value" placeholder="Từ khóa"/>
                            </span>
                        </div>
                    </template>
                    <template #empty> Không có địa điểm nào</template>
                    <template #loading>
                        <ProgressSpinner/>
                        Đang tải dữ liệu ...
                    </template>
                    <Column selectionMode="multiple" headerStyle="width: 3rem">
                    </Column>
                    <Column field="name" header="Tên địa điem" sortable>
                        <template #body="{ data }">
                            {{ data.name }}
                        </template>
                        <template
                            #filter="{ filterModel, filterCallback }">
                            <InputText v-model="filterModel.value"
                                       type="text"
                                       @input="filterCallback()"
                                       class="p-column-filter"
                                       placeholder="Tìm tên địa điểm"/>
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
                                       placeholder="Tìm mô tả"/>
                        </template>
                    </Column>
                    <Column field="address" header="Địa chỉ" sortable>
                        <template #body="{ data }">
                            {{ data.address }}
                        </template>
                        <template
                            #filter="{ filterModel, filterCallback }">
                            <InputText v-model="filterModel.value"
                                       type="text"
                                       @input="filterCallback()"
                                       class="p-column-filter"
                                       placeholder="Tìm địa chỉ"/>
                        </template>
                    </Column>
                    <Column :exportable="false" style="min-width:9rem">
                        <template #body="slotProps">
                            <Button icon="pi pi-pencil"
                                    outlined
                                    rounded
                                    class="mr-2"
                                    @click="editPlace(slotProps.data)"/>
                            <Button icon="pi pi-trash"
                                    outlined
                                    rounded
                                    severity="danger"
                                    @click="confirmDeletePlace(slotProps.data)"/>
                        </template>
                    </Column>
                </DataTable>
                <Dialog v-model:visible="placeDialog" :style="{ width: '450px' }"
                        header="Chỉnh sủa xe" :modal="true" class="p-fluid">
                    <div class="p-field">
                        <label for="name">Tên địa điểm</label>
                        <InputText id="name"
                                   v-model="place.name"
                                   :class="{ 'p-invalid': submitted && !place.name }"
                                   required autofocus/>
                        <div v-if="submitted && !place.name"
                             class="p-invalid">Tên địa điểm không được để trống
                        </div>
                    </div>
                    <div class="p-field">
                        <label for="description">Mô tả</label>
                        <InputText id="description" v-model="place.description"
                                   :class="{ 'p-invalid': submitted && !place.description }"
                                   required/>
                        <div v-if="submitted && !place.description"
                             class="p-invalid">Mô tả
                            không được để trống
                        </div>
                    </div>
                    <div class="p-field">
                        <label for="address">Địa chỉ</label>
                        <InputText id="address"
                                   v-model="place.address"
                                   :class="{ 'p-invalid': submitted && !place.address }"
                                   required/>
                        <div v-if="submitted && !place.address" class="p-invalid">Địa chỉ không được để trống
                        </div>
                    </div>
                    <template #footer>
                        <Button label="Hủy" icon="pi pi-times"
                                class="p-button-text"
                                @click="placeDialog = false"/>
                        <Button label="Lưu" icon="pi pi-check"
                                class="p-button-text"
                                @click="savePlace()"/>
                    </template>
                </Dialog>
                <Dialog v-model:visible="deletePlaceDialog" modal header="Xóa xe"
                        :style="{ width: '450px' }">
                    <div class="confirmation-content">
                        <i class="pi pi-exclamation-triangle p-mr-3"
                           style="font-size: 2rem;color: #f44336"></i>
                        <span v-if="place">Bạn có chắc chắn muốn xóa địa điểm có địa chỉ <b>{{
                                place.address
                            }}</b>?</span>
                    </div>
                    <template #footer>
                        <Button label="Hủy" icon="pi pi-times"
                                class="p-button-text"
                                @click="deletePlaceDialog = false"/>
                        <Button label="Xóa" icon="pi pi-check"
                                class="p-button-text"
                                @click="deletePlace"/>
                    </template>
                </Dialog>
                <Dialog v-model:visible="deletePlacesDialog" modal header="Xóa xe"
                        :style="{ width: '450px' }">
                    <div class="confirmation-content">
                        <i class="pi pi-exclamation-triangle p-mr-3"
                           style="font-size: 2rem;color: #f44336"></i>
                        <span>Bạn có chắc chắn muốn xóa địa điểm đã chọn?</span>
                    </div>
                    <template #footer>
                        <Button label="Hủy" icon="pi pi-times"
                                class="p-button-text"
                                @click="deletePlacesDialog = false"/>
                        <Button label="Xóa" icon="pi pi-check"
                                class="p-button-text"
                                @click="deleteSelectedPlaces"/>
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
            places: null,
            loading: true,
            metaKey: true,
            selectedPlace: null,
            selectedPlaces: null,
            deletePlaceDialog: false,
            deletePlacesDialog: false,
            submitted: false,
            placeDialog: false,
            place: {
                id: null,
                name: null,
                description: null,
                address: null,
            },
            filters: {
                global: {value: null, matchMode: FilterMatchMode.CONTAINS},
                name: {value: null, matchMode: FilterMatchMode.STARTS_WITH},
                description: {value: null, matchMode: FilterMatchMode.STARTS_WITH},
                address: {value: null, matchMode: FilterMatchMode.STARTS_WITH},
            },
        };
    },
    mounted() {
        axios.get("http://127.0.0.1:8000/api/places")
            .then(res => {
                this.places = res.data;
                this.loading = false;

            })
            .catch(err => {
                console.log(err);
            });
    },
    methods: {
        hideDialog() {
            this.placeDialog = false;
            this.submitted = false;
        },
        confirmDeletePlace(place) {
            this.place = place;
            this.deletePlaceDialog = true;
        },
        deletePlace() {
            axios.delete(`http://127.0.0.1:8000/api/places/${this.place.id}`)
                .then(res => {
                    this.places = this.places.filter(val => val.id !== this.place.id);
                    this.deletePlaceDialog = false;
                    this.place = {};
                    this.$toast.add({
                        severity: "success",
                        summary: "Thành công",
                        detail: "Xóa địa điểm thành công",
                        life: 3000,
                    });
                })
                .catch(err => {
                    console.log(err);
                    this.$toast.add({
                        severity: "error",
                        summary: "Thất bại",
                        detail: "Xóa địa điểm thất bại",
                        life: 3000,
                    });
                });
        },
        exportCSV() {
            this.$refs.dt.exportCSV();
        },
        confirmDeleteSelected() {
            this.deletePlacesDialog = true;
        },
        deleteSelectedTPlaces() {
            let places = this.selectedPlaces;
            this.deletePlacesDialog = false;
            places.forEach(place => {
                axios.delete(`http://127.0.0.1:8000/api/places/${place.id}`)
                    .then(res => {
                        this.places = this.places.filter(val => val.id !== place.id);
                        this.selectedPlaces = null;
                        this.$toast.add({
                            severity: "success",
                            summary: "Thành công",
                            detail: "Xóa địa điểm thành công",
                            life: 3000,
                        });
                    })
                    .catch(err => {
                        console.log(err);
                        this.$toast.add({
                            severity: "error",
                            summary: "Thất bại",
                            detail: "Xóa địa điểm thất bại",
                            life: 3000,
                        });
                    });
            });
        },
        savePlace() {
            this.submitted = true;
            if (this.place.name.trim()) {
                if (this.place.id) {
                    axios.put(`http://127.0.0.1:8000/api/places/${this.place.id}`, this.place)
                        .then(res => {
                            this.$toast.add({
                                severity: "success",
                                summary: "Thành công",
                                detail: "Cập nhật địa điểm thành công",
                                life: 3000,
                            });
                            this.placeDialog = false;
                            this.place = {};
                            this.submitted = false;
                        })
                        .catch(err => {
                            console.log(err);
                            this.$toast.add({
                                severity: "error",
                                summary: "Thất bại",
                                detail: "Cập nhật địa điểm thất bại",
                                life: 3000,
                            });
                        });
                } else {
                    axios.post("http://127.0.0.1:8000/api/places", this.place)
                        .then(res => {
                            this.$toast.add({
                                severity: "success",
                                summary: "Thành công",
                                detail: "Thêm địa điểm thành công",
                                life: 3000,
                            });
                            this.placeDialog = false;
                            this.place = {};
                            this.submitted = false;
                        })
                        .catch(err => {
                            console.log(err);
                            this.$toast.add({
                                severity: "error",
                                summary: "Thất bại",
                                detail: "Thêm địa điểm thất bại",
                                life: 3000,
                            });
                        });
                }
                this.user = null;
                this.userDialog = false;
            }
        },
        openNew() {
            this.place = {};
            this.submitted = false;
            this.placeDialog = true;
        },
        onRowSelect(event) {
            this.$toast.add({
                severity: "info",
                summary: "Địa điểm đã được chọn",
                detail: "Địa chi: " + event.data.address,
                life: 3000,
            });
        },
        editPlace(place) {
            this.place = {...place};
            this.placeDialog = true;
        },

    },
}
</script>
