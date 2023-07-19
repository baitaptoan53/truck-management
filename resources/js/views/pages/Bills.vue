<template>
               <Toast />
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
                                                                           <template #loading> <ProgressSpinner /> Đang tải dữ liệu...</template>
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
                                                                           <Column :exportable="false" style="min-width:9rem">
                                                                                          <template #body="slotProps">
                                                                                                         <Button icon="pi pi-eye"
                                                                                                                        outlined
                                                                                                                        rounded
                                                                                                                        class="mr-2"
                                                                                                                        @click="showInvoice(slotProps.data)" />
                                                                                                         <!-- <Button icon="pi pi-trash"
                                                                                                                        outlined
                                                                                                                        rounded
                                                                                                                        severity="danger"
                                                                                                                        @click="confirmDeleteUser(slotProps.data)" /> -->
                                                                                          </template>
                                                                           </Column>
                                                            </DataTable>
                                                            <Dialog v-model:visible="invoiceDialog" :style="{ width: '80%' }"
                                                                           :modal="true" class="p-fluid">
                                                                           <template #header>
                                                                                          <div style="text-align: left" class="mr-2">
                                                                                                         <Button icon="pi pi-print"
                                                                                                                        label="In"
                                                                                                                        @click="print" />
                                                                                          </div>
                                                                           </template>
                                                                           <div class="grid">
                                                                                          <div class="col">
                                                                                                         <div class="card">
                                                                                                                        <div
                                                                                                                                       id="invoice-content">
                                                                                                                                       <div
                                                                                                                                                      class="invoice">
                                                                                                                                                      <div
                                                                                                                                                                     class="invoice-header">
                                                                                                                                                                     <div
                                                                                                                                                                                    class="invoice-company">
                                                                                                                                                                                    <img id="invoice-logo"
                                                                                                                                                                                                   class="logo-image"
                                                                                                                                                                                                   src="/layout/images/logo-freya-single.svg"
                                                                                                                                                                                                   alt="freya-layout">
                                                                                                                                                                                    <div
                                                                                                                                                                                                   class="company-name">
                                                                                                                                                                                                   TRUCK
                                                                                                                                                                                                   EXPRESS

                                                                                                                                                                                    </div>
                                                                                                                                                                                    <div>1 Đại La - Hai
                                                                                                                                                                                                   Bà
                                                                                                                                                                                                   Trưng
                                                                                                                                                                                    </div>
                                                                                                                                                                                    <div>Hà Nội, Việt
                                                                                                                                                                                                   Nam
                                                                                                                                                                                    </div>
                                                                                                                                                                     </div>
                                                                                                                                                                     <div>
                                                                                                                                                                                    <div
                                                                                                                                                                                                   class="invoice-title">
                                                                                                                                                                                                   HÓA
                                                                                                                                                                                                   ĐƠN
                                                                                                                                                                                    </div>
                                                                                                                                                                                    <div
                                                                                                                                                                                                   class="invoice-details">
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-label">
                                                                                                                                                                                                                  Ngày
                                                                                                                                                                                                                  tạo
                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-value">
                                                                                                                                                                                                                  {{
                                                                                                                                                                                                                                 invoice.invoice_date
                                                                                                                                                                                                                  }}
                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-label">
                                                                                                                                                                                                                  INVOICE
                                                                                                                                                                                                                  #
                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-value">
                                                                                                                                                                                                                  #{{
                                                                                                                                                                                                                                 invoice.id
                                                                                                                                                                                                                  }}
                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-label">
                                                                                                                                                                                                                  MÃ
                                                                                                                                                                                                                  TÀI
                                                                                                                                                                                                                  XẾ
                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-value">
                                                                                                                                                                                                                  C1613
                                                                                                                                                                                                   </div>
                                                                                                                                                                                    </div>
                                                                                                                                                                     </div>
                                                                                                                                                      </div>
                                                                                                                                                      <div
                                                                                                                                                                     class="invoice-to">
                                                                                                                                                                     <div
                                                                                                                                                                                    class="bill-to">
                                                                                                                                                                                    GỬI
                                                                                                                                                                                    ĐẾN
                                                                                                                                                                     </div>
                                                                                                                                                                     <div
                                                                                                                                                                                    class="invoice-to-info">
                                                                                                                                                                                    <div>Claire Williams,
                                                                                                                                                                                                   148
                                                                                                                                                                                                   Hope
                                                                                                                                                                                                   Lane
                                                                                                                                                                                    </div>
                                                                                                                                                                                    <div>Palo Alto, CA
                                                                                                                                                                                                   94304.
                                                                                                                                                                                    </div>
                                                                                                                                                                     </div>
                                                                                                                                                      </div>
                                                                                                                                                      <div
                                                                                                                                                                     class="invoice-items">
                                                                                                                                                                     <table>
                                                                                                                                                                                    <thead>
                                                                                                                                                                                                   <tr>
                                                                                                                                                                                                                  <th>Tên chuyến xe
                                                                                                                                                                                                                  </th>
                                                                                                                                                                                                                  <th>Số KM
                                                                                                                                                                                                                  </th>
                                                                                                                                                                                                                  <th>Ngày đi - Ngày
                                                                                                                                                                                                                                 đến
                                                                                                                                                                                                                  </th>
                                                                                                                                                                                                                  <th>Thành tiền
                                                                                                                                                                                                                  </th>
                                                                                                                                                                                                   </tr>
                                                                                                                                                                                    </thead>
                                                                                                                                                                                    <tbody>
                                                                                                                                                                                                   <tr>
                                                                                                                                                                                                                  <td>{{ invoice.start_location
                                                                                                                                                                                                                  }}
                                                                                                                                                                                                                                 -
                                                                                                                                                                                                                                 {{
                                                                                                                                                                                                                                                invoice.end_location
                                                                                                                                                                                                                                 }}
                                                                                                                                                                                                                  </td>
                                                                                                                                                                                                                  <td>{{ invoice.total_distance
                                                                                                                                                                                                                  }}
                                                                                                                                                                                                                  </td>
                                                                                                                                                                                                                  <td>{{ invoice.start_date
                                                                                                                                                                                                                  }}
                                                                                                                                                                                                                                 -
                                                                                                                                                                                                                                 {{
                                                                                                                                                                                                                                                invoice.end_date
                                                                                                                                                                                                                                 }}
                                                                                                                                                                                                                  </td>
                                                                                                                                                                                                                  <td>{{ invoice.total_amount
                                                                                                                                                                                                                  }}
                                                                                                                                                                                                                                 VND
                                                                                                                                                                                                                  </td>
                                                                                                                                                                                                   </tr>
                                                                                                                                                                                    </tbody>
                                                                                                                                                                     </table>
                                                                                                                                                      </div>
                                                                                                                                                      <div
                                                                                                                                                                     class="invoice-summary">
                                                                                                                                                                     <div
                                                                                                                                                                                    class="invoice-notes">
                                                                                                                                                                                    <b>Ghi
                                                                                                                                                                                                   chú</b>
                                                                                                                                                                                    <div>
                                                                                                                                                                                    </div>
                                                                                                                                                                     </div>
                                                                                                                                                                     <div>
                                                                                                                                                                                    <div
                                                                                                                                                                                                   class="invoice-details">
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-label">
                                                                                                                                                                                                                  CỘNG
                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-value">
                                                                                                                                                                                                                  {{
                                                                                                                                                                                                                                 invoice.total_amount
                                                                                                                                                                                                                  }}
                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-label">
                                                                                                                                                                                                                  VAT 10%
                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-value">
                                                                                                                                                                                                                  {{invoice.total_amount*0.1}}

                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-label">
                                                                                                                                                                                                                  TỔNG TIỀN
                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-value">
                                                                                                                                                                                                                  {{invoice.total_amount*1.1}}
                                                                                                                                                                                                   </div>
                                                                                                                                                                                    </div>
                                                                                                                                                                     </div>
                                                                                                                                                      </div>
                                                                                                                                       </div>
                                                                                                                        </div>
                                                                                                         </div>
                                                                                          </div>
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
                                             invoiceDialog: false,
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
                              print() {
                                             var card = document.getElementById("invoice-content");
                                             var htmlContent = '';
                                             var style = document.getElementsByTagName("style");
                                             for (var i = 0; i < style.length; i++) {
                                                            htmlContent += style[i].outerHTML;
                                             }
                                             htmlContent += '</head><body>';
                                             htmlContent += card.outerHTML;
                                             htmlContent += '</body></html>';
                                             var printWin = window.open('', '', 'width=1000,height=600');
                                             printWin.document.open();
                                             printWin.document.write(htmlContent);
                                             printWin.focus();
                                             printWin.print();
                              },
                              hideDialog() {
                                             this.invoiceDialog = false;
                              },
                              showInvoice(invoice) {
                                             this.invoice = { ...invoice };
                                             this.invoiceDialog = true;
                              },


               }
}
</script>
<style scoped>
.invoice {
               padding: 2rem;
}

.invoice .invoice-header {
               display: -ms-flexbox;
               display: flex;
               -ms-flex-pack: justify;
               justify-content: space-between;
}

.invoice .invoice-company .logo-image {
               height: 50px;
               margin-bottom: 0.5rem;
}

.invoice .invoice-company div {
               margin-bottom: 0.5rem;
}

.invoice .invoice-company .company-name {
               font-weight: 500;
               font-size: 1.5rem;
}

.invoice .invoice-title {
               font-size: 2rem;
               margin-bottom: 2rem;
               text-align: right;
               font-weight: 300;
}

.invoice .invoice-details {
               width: 15rem;
               display: -ms-flexbox;
               display: flex;
               -ms-flex-wrap: wrap;
               flex-wrap: wrap;
}

.invoice .invoice-details>div {
               width: 50%;
               margin-bottom: 0.5rem;
}

.invoice .invoice-details .invoice-label {
               text-align: left;
               font-weight: 500;
}

.invoice .invoice-details .invoice-value {
               text-align: right;
}

.invoice .invoice-to {
               margin-top: 1.5rem;
               padding-top: 2rem;
               border-top: 1px solid #F2F4F6;
}

.invoice .invoice-to .bill-to {
               font-size: 1.25rem;
               font-weight: 500;
               margin-bottom: 0.5rem;
}

.invoice .invoice-to .invoice-to-info div {
               margin-bottom: 0.5rem;
}

.invoice .invoice-items {
               margin-top: 2rem;
               padding-top: 2rem;
}

.invoice .invoice-items table {
               width: 100%;
               border-collapse: collapse;
}

.invoice .invoice-items table tr {
               border-bottom: 1px solid #F2F4F6;
}

.invoice .invoice-items table th {
               font-weight: 500;
}

.invoice .invoice-items table th,
.invoice .invoice-items table td {
               padding: 1rem;
               text-align: right;
}

.invoice .invoice-items table th:first-child,
.invoice .invoice-items table td:first-child {
               text-align: left;
}

.invoice .invoice-summary {
               display: -ms-flexbox;
               display: flex;
               -ms-flex-pack: justify;
               justify-content: space-between;
               margin-top: 2.5rem;
               padding-top: 2.5rem;
}

.invoice .invoice-summary .invoice-value {
               font-weight: 500;
}

@media print {
               body * {
                              visibility: hidden;
               }

               #invoice-content * {
                              visibility: visible;
               }

               #invoice-content {
                              width: 100%;
                              position: absolute;
                              left: 0;
                              top: 0;
                              padding: 0;
                              margin: 0;
               }

               .invoice {
                              padding: 0;
                              margin: 0;
                              background: #ffffff;
                              color: #424242;
               }
}</style>