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
                    v-model="formData.provincy_name"
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
                    v-model="formData.regency_name"
                    :items="regencyData"
                    item-title="nama"
                    item-value="id"
                    label="Regency"
                    placeholder="Select Regency"
                    prepend-inner-icon="bx-home"
                    return-object
                  ></v-select>
                </VCol>

                <VCol cols="6">
                  <VTextField
                    v-model="formData.address"
                    prepend-inner-icon="bx-location-plus"
                    label="Address"
                    placeholder="Jl *******"
                    type="text"
                  />
                </VCol>
                <VCol cols="6">
                  <v-select
                    v-model="roleId"
                    :items="roleData"
                    item-title="name"
                    item-value="value"
                    label="Role"
                    placeholder="Select Role"
                    prepend-inner-icon="bx-home"
                    return-object
                  ></v-select>
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
      roleId: "",
      provinceData: [],
      regencyData: [],
      roleData: [
        { name: "Admin", value: 1 },
        { name: "Kepala Sekolah", value: 3 },
      ],
    };
  },
  mounted: function () {
    this.$nextTick().then(this.getUsersEdit);
    this.$nextTick().then(this.getProvince);
  },
  watch: {
    province: function (params) {
      this.getRegency(params);
    },
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
    getUsersEdit() {
      //init formData
      let token = JSON.parse(localStorage.getItem("token"));
      const data = axios
        .get(
          "http://127.0.0.1:8000/api/users/showUsers/" + this.$route.query.id,
          {
            headers: {
              Accept: "application/json",
              Authorization: "Bearer " + token,
            },
          }
        )
        .then((response) => this.formData = response.data.data);
    //   items.value = data;

    //   console.log(this.formData);
    },
    updateUsers() {
      let token = JSON.parse(localStorage.getItem("token"));
      var dataEdit = {
        name: this.formData.name,
        email: this.formData.email,
        phone: this.formData.phone,
        password: this.formData.password,
      };
      console.log(this.formData);
      //init formData

      const data = axios
        .post("http://127.0.0.1:8000/api/updateUsers/", dataEdit, {
          headers: {
            Accept: "application/json",
            Authorization: "Bearer " + token,
          },
        })
        .then((response) => response.data.data);
      // items.value = data;

      // console.log(data);
    },
  },
};
</script>
