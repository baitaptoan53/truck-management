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
                                                                                                                                                                                                                  30/08/2019
                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-label">
                                                                                                                                                                                                                  INVOICE
                                                                                                                                                                                                                  #
                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-value">
                                                                                                                                                                                                                  8523
                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-label">
                                                                                                                                                                                                                  CUSTOMER
                                                                                                                                                                                                                  ID
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
                                                                                                                                                                                    BILL
                                                                                                                                                                                    TO
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
                                                                                                                                                                                                                  <th>Description
                                                                                                                                                                                                                  </th>
                                                                                                                                                                                                                  <th>Quantity
                                                                                                                                                                                                                  </th>
                                                                                                                                                                                                                  <th>Unit Price
                                                                                                                                                                                                                  </th>
                                                                                                                                                                                                                  <th>Line Total
                                                                                                                                                                                                                  </th>
                                                                                                                                                                                                   </tr>
                                                                                                                                                                                    </thead>
                                                                                                                                                                                    <tbody>
                                                                                                                                                                                                   <tr>
                                                                                                                                                                                                                  <td>Green T-Shirt
                                                                                                                                                                                                                  </td>
                                                                                                                                                                                                                  <td>1
                                                                                                                                                                                                                  </td>
                                                                                                                                                                                                                  <td>$49.00
                                                                                                                                                                                                                  </td>
                                                                                                                                                                                                                  <td>$49.00
                                                                                                                                                                                                                  </td>
                                                                                                                                                                                                   </tr>
                                                                                                                                                                                                   <tr>
                                                                                                                                                                                                                  <td>Game Controller
                                                                                                                                                                                                                  </td>
                                                                                                                                                                                                                  <td>2
                                                                                                                                                                                                                  </td>
                                                                                                                                                                                                                  <td>$99.00
                                                                                                                                                                                                                  </td>
                                                                                                                                                                                                                  <td>$198.00
                                                                                                                                                                                                                  </td>
                                                                                                                                                                                                   </tr>
                                                                                                                                                                                                   <tr>
                                                                                                                                                                                                                  <td>Mini Speakers
                                                                                                                                                                                                                  </td>
                                                                                                                                                                                                                  <td>1
                                                                                                                                                                                                                  </td>
                                                                                                                                                                                                                  <td>$85.00
                                                                                                                                                                                                                  </td>
                                                                                                                                                                                                                  <td>$85.00
                                                                                                                                                                                                                  </td>
                                                                                                                                                                                                   </tr>
                                                                                                                                                                                    </tbody>
                                                                                                                                                                     </table>
                                                                                                                                                      </div>
                                                                                                                                                      <div
                                                                                                                                                                     class="invoice-summary">
                                                                                                                                                                     <div
                                                                                                                                                                                    class="invoice-notes">
                                                                                                                                                                                    <b>NOTES</b>
                                                                                                                                                                                    <div>
                                                                                                                                                                                    </div>
                                                                                                                                                                     </div>
                                                                                                                                                                     <div>
                                                                                                                                                                                    <div
                                                                                                                                                                                                   class="invoice-details">
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-label">
                                                                                                                                                                                                                  SUBTOTAL
                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-value">
                                                                                                                                                                                                                  $332.00
                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-label">
                                                                                                                                                                                                                  VAT
                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-value">
                                                                                                                                                                                                                  0
                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-label">
                                                                                                                                                                                                                  TOTAL
                                                                                                                                                                                                   </div>
                                                                                                                                                                                                   <div
                                                                                                                                                                                                                  class="invoice-value">
                                                                                                                                                                                                                  $332.00
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
                                             invoiceDialog: true,
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
                              print(el) {
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
}
</style>