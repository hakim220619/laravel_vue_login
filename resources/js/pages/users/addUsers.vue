<template>
  <div>
    <VRow>
      <VCol cols="12" md="12">
        <VCard title="Add Users">
          <VCardText>
            <VForm @submit.prevent="storeUsers()">
              <VRow>
                <VCol cols="6">
                  <VTextField
                    v-model="formData.full_name"
                    prepend-inner-icon="bx-user"
                    label="First Name"
                    placeholder="John"
                  />
                </VCol>

                <VCol cols="6">
                  <VTextField
                    v-model="formData.email"
                    prepend-inner-icon="bx-envelope"
                    label="Email"
                    type="email"
                    placeholder="johndoe@example.com"
                  />
                </VCol>

                <VCol cols="6">
                  <VTextField
                    v-model="formData.phone"
                    prepend-inner-icon="bx-mobile"
                    label="Mobile"
                    placeholder="+1 123 456 7890"
                    type="number"
                  />
                </VCol>

                <VCol cols="6">
                  <VTextField
                    v-on:change="onChange"
                    prepend-inner-icon="bx-images"
                    label="Image"
                    type="file"
                  />
                </VCol>
                <VCol cols="6">
                  <VTextField
                    v-model="formData.date_ofbirth"
                    prepend-inner-icon="bx-calendar"
                    label="Date"
                    type="date"
                  />
                </VCol>
                <VCol cols="6">
                  <VTextField
                    v-model="formData.password"
                    prepend-inner-icon="bx-lock"
                    label="Password"
                    type="password"
                    placeholder="············"
                  />
                </VCol>
                <VCol cols="6">
                  <v-select
                    v-model="province"
                    :items="provinceData"
                    item-title="nama"
                    item-value="id"
                    label="Province"
                    placeholder="Select Province"
                    prepend-inner-icon="bx-home"
                    return-object
                  ></v-select>
                </VCol>
                <VCol cols="6">
                  <v-select
                    v-model="formData.regency"
                    :items="regencyData"
                    item-title="nama"
                    item-value="id"
                    label="Regency"
                    placeholder="Select Regency"
                    prepend-inner-icon="bx-home"
                    return-object
                  ></v-select>
                </VCol>

                <VCol cols="12">
                  <VTextField
                    v-model="formData.address"
                    prepend-inner-icon="bx-location-plus"
                    label="Address"
                    placeholder="Jl *******"
                    type="text"
                  />
                </VCol>

                <VCol cols="12">
                  <VBtn type="submit" class="me-2"> Submit </VBtn>

                  <VBtn color="secondary" to="users" variant="tonal">
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
      file: "",
      formData: [],
      province: "",
      provinceData: [],
      regencyData: [],
    };
  },
  watch: {
    province: function (params) {
      this.getRegency(params);
    },
  },
  mounted() {
    this.$nextTick().then(this.getProvince);
    // this.$nextTick().then(this.getRegency);
  },
  methods: {
    onChange(e) {
      this.file = e.target.files[0];
    },
    getProvince() {
      let token = JSON.parse(localStorage.getItem("token"));
      const data = axios
        .get("http://127.0.0.1:8000/api/getProvince", {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + token,
          },
        })
        .then((response) => (this.provinceData = response.data.data));
      // console.log(this.provinceData);
    },
    getRegency(params) {
      let token = JSON.parse(localStorage.getItem("token"));
      const data = axios
        .get("http://127.0.0.1:8000/api/getRegency/" + params.id, {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + token,
          },
        })
        .then((response) => (this.regencyData = response.data.data));
    },
    storeUsers() {
      //init formData
      let token = JSON.parse(localStorage.getItem("token"));
      let data = new FormData();
      //   console.log(this.formData);
      //   console.log(this.province);
      data.append("full_name", this.formData.full_name);
      data.append("email", this.formData.email);
      data.append("phone", this.formData.phone);
      data.append("address", this.formData.address);
      data.append("date_ofbirth", this.formData.date_ofbirth);
      data.append("province_id", this.province.id);
      data.append("regency_id", this.formData.regency.id);
      data.append("password", this.formData.password);
      data.append("file", this.file);
      console.log(data);
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
              .post("http://localhost:8000/api/addUsers", data, {
                headers: {
                  Accept: "application/json",
                  Authorization: "Bearer " + token,
                },
              })
              .then((response) =>
                // console.log(response.data.token),

                this.$router.push({ name: "users" })
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
                  title: "Insert Users Success..",
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
