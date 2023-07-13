<template>
               <div class="p-grid">
                              <div class="p-col-12">
                                             <div class="card">
                                                            <Toolbar #start>
                                                                           <h3>Hóa đơn</h3>
                                                            </Toolbar>
                                                            <DataTable :value="invoices" tableStyle="min-width: 50rem" removableSort
                                                                           paginator :rows="5" filterDisplay="row"
                                                                           :rowsPerPageOptions="[5, 10, 20, 50]" :loading="loading"
                                                                           v-model:filters="filters" dataKey="id">
                                                                           <template #empty> No customers found. </template>
                                                                           <template #loading> Loading customers data. Please
                                                                                          wait.</template>
                                                                           <Column field="id" header="Mã hóa đơn" sortable></Column>
                                                                           <Column field="trip_id" header="Trip ID" sortable></Column>
                                                                           <Column field="invoice_date" header="Ngày tạo" sortable>
                                                                           </Column>
                                                                           <Column field="total_amount" header="Tổng tiền" sortable>
                                                                           </Column>
                                                                           <Column field="status" header="Trạng thái" sortable>
                                                                                          <template #body="{ data }">
                                                                                                         <Badge
                                                                                                                        :severity="getSeverity(data)">
                                                                                                                        {{ data.status
                                                                                                                        }}
                                                                                                         </Badge>
                                                                                          </template>
                                                                           </Column>
                                                                           <Column field="action" :body-style="{ 'width': '8em' }">
                                                                                          <template #body="{ slotProps }">
                                                                                                         <Button icon="pi pi-pencil"
                                                                                                                        outlined
                                                                                                                        rounded
                                                                                                                        class="mr-2"
                                                                                                                        @click="viewInvoice(slotProps.data)" />
                                                                                                         <!-- <Button type="button"
                                                                                                                        icon="pi pi-pencil"
                                                                                                                        class="p-button-rounded p-button-warning"
                                                                                                                        @click="editInvoice(slotProps.data)"></Button> -->
                                                                                          </template>
                                                                           </Column>
                                                            </DataTable>
                                                            <Dialog v-model:visible="showInvoicesDialog" :style="{ width: '450px' }"
                                                                           header="Thông tin hóa đơn" :modal="true" :closable="true"
                                                                           class="p-fluid">
                                                                           <!-- hiển thị thông tin hóa đơn phía trên cùng bên tay phải -->
                                                                           <div class="p-field">
                                                                                          <label for="id">Mã hóa đơn <b>{{ invoice.id
                                                                                          }}</b></label>
                                                                           </div>

                                                            </Dialog>

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
                                             invoices: null,
                                             loading: true,
                                             columns: null,
                                             showInvoicesDialog: false,
                                             statuses: [
                                                            { label: 'Đã thanh toán', value: 'paid' },
                                                            { label: 'Chưa thanh toán', value: 'unpaid' },
                                             ]
                              }
               },
               mounted() {
                              axios.get("http://127.0.0.1:8000/api/invoices")
                                             .then(res => {
                                                            this.invoices = res.data;
                                                            this.loading = false;

                                             })
                                             .catch(err => {
                                                            console.log(err);
                                             });
               },
               methods: {
                              getSeverity(invoices) {
                                             switch (invoices.status) {
                                                            case 'paid':
                                                                           return 'success';

                                                            case 'unpaid':
                                                                           return 'warning';

                                                            default:
                                                                           return null;
                                             }
                              },
               }
}
</script>