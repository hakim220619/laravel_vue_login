<template>
  <div>
    <VRow>
      <VCol cols="12" md="12">
        <VCard title="Add Bill Payment">
          <VCardText>
            <VForm @submit.prevent="storeBillPayment()">
              <VRow>
                <VCol cols="6">
                  <VTextField
                    v-model="formData.bill_name"
                    prepend-inner-icon="bx-user"
                    label="Bill Name"
                    placeholder="John"
                  />
                </VCol>

                <VCol cols="6">
                  <VTextField
                    v-model="formData.desc"
                    prepend-inner-icon="bx-map"
                    label="Description"
                    type="text"
                    placeholder="abbxd****"
                  />
                </VCol>
                <VCol cols="6">
                  <v-select
                    v-model="formData.years"
                    :items="yearsData"
                    item-title="years"
                    item-value="years"
                    label="Years"
                    placeholder="Select Years"
                    prepend-inner-icon="bx-home"
                    return-object
                  ></v-select>
                </VCol>
                <VCol cols="6">
                  <v-select
                    v-model="formData.type"
                    :items="typeData"
                    item-title="name"
                    item-value="value"
                    label="Type"
                    placeholder="Select Type"
                    prepend-inner-icon="bx-home"
                    return-object
                  ></v-select>
                </VCol>
                <VCol cols="12">
                  <VBtn type="submit" class="me-2"> Submit </VBtn>

                  <VBtn color="secondary" to="settingPayment" variant="tonal">
                    Kembali
                  </VBtn>
                </VCol>
              </VRow>
            </VForm>
          </VCardText>
        </VCard>
      </VCol>
    </VRow>
  </div>
</template>
<script>
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();

export default {
  data() {
    return {
      formData: [],
      yearsData: [],
      typeData: [
        { name: "BULANAN", value: "BULANAN" },
        { name: "BEBAS", value: "BEBAS" },
      ],
    };
  },
  mounted() {
    this.$nextTick().then(this.getYears);
    // this.$nextTick().then(this.getRegency);
  },
  methods: {
    getYears() {
      let token = JSON.parse(localStorage.getItem("token"));
      const data = axios
        .get("http://127.0.0.1:8000/api/getYears", {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + token,
          },
        })
        .then((response) => (this.yearsData = response.data.data));
      // console.log(this.yearsData);
    },
    storeBillPayment() {
      //init formData
      let token = JSON.parse(localStorage.getItem("token"));
      let data = new FormData();
      //   console.log(this.formData);
      //   console.log(this.province);
      data.append("bill_name", this.formData.bill_name);
      data.append("desc", this.formData.desc);
      data.append("years", this.formData.years.years);
      data.append("type", this.formData.type.value);
      console.log(this.formData);
      let timerInterval;
      this.$swal
        .fire({
          title: "",
          html: "Loading...",
          timer: 3000,
          timerProgressBar: true,
          didOpen: () => {
            this.$swal.showLoading();
            axios
              .post("http://localhost:8000/api/addBillPayment", data, {
                headers: {
                  Accept: "application/json",
                  Authorization: "Bearer " + token,
                },
              })
              .then((response) =>
                // console.log(response.data.token),

                this.$router.push({ name: "settingPayment" })
              )
              .catch((err) => console.log(err))
              .finally(() => {
                const Toast = this.$swal.mixin({
                  toast: true,
                  position: "top-end",
                  showConfirmButton: false,
                  timer: 3000,
                  timerProgressBar: true,
                });
                Toast.fire({
                  icon: "success",
                  title: "Insert Bill Payment Success..",
                });
              });
          },
          willClose: () => {
            clearInterval(timerInterval);
          },
        })
        .then((result) => {
          /* Read more about handling dismissals below */
          if (result.dismiss === Swal.DismissReason.timer) {
          }
        });
    },
  },
};
</script>
