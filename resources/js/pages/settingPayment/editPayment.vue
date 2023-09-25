<template>
  <div>
    <VRow>
      <VCol cols="12" md="12">
        <VCard title="Add Bill Payment">
          <VCardText>
            <VForm @submit="formSubmit">
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
                  <v-select
                    v-model="formData.status"
                    :items="getStatus"
                    label="Status"
                    placeholder="Select Status"
                    prepend-inner-icon="bx-home"
                    return-object
                  ></v-select>
                </VCol>
                <VCol cols="12">
                  <VTextField
                    v-model="formData.desc"
                    prepend-inner-icon="bx-map"
                    label="Description"
                    type="text"
                    placeholder="abbxd****"
                  />
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
      getStatus: ["ON", "OFF"],
      password: "",
      formData: [],
    };
  },
  mounted: function () {
    this.$nextTick().then(this.getBillPaymentShow);
  },
  methods: {
    async getBillPaymentShow() {
      //init formData
      let token = JSON.parse(localStorage.getItem("token"));
      const data = await axios
        .get(
          "http://127.0.0.1:8000/api/showBillPayment/" + this.$route.query.id,
          {
            headers: {
              Accept: "application/json",
              Authorization: "Bearer " + token,
            },
          }
        )
        .then((response) => (this.formData = response.data.data));
      // items.value = data;

      // console.log(this.formData.class_name);
    },
    formSubmit(e) {
      e.preventDefault();
      let token = JSON.parse(localStorage.getItem("token"));
      let data = new FormData();
      data.append("id", this.formData.id);
      data.append("bill_name", this.formData.bill_name);
      data.append("desc", this.formData.desc);
      data.append("status", this.formData.status);
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
              .post("http://localhost:8000/api/UpdateBillPayment", data, {
                headers: {
                  Accept: "application/json",
                  "Content-Type": "multipart/form-data",
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
                  title: "Update Success..",
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
