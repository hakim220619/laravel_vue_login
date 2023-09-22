<template>
  <div>
    <VRow>
      <VCol cols="12" md="12">
        <VCard title="Update Users">
          <VCardText>
            <VForm @submit.prevent="updateUsers()">
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
                    v-model="password"
                    prepend-inner-icon="bx-lock"
                    label="Password"
                    type="password"
                    placeholder="············"
                  />
                </VCol>
                <VCol cols="6">
                  <v-select
                    v-model="province"
                    v-on:change="province"
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
                  <v-select
                    v-model="formData.status"
                    :items="getStatus"
                    label="Status"
                    placeholder="Select Status"
                    prepend-inner-icon="bx-home"
                    return-object
                  ></v-select>
                </VCol>

                <VCol cols="6">
                  <v-select
                    v-model="formData.role_name"
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
      getStatus: ["ON", "OFF"],
      province: "",
      roleId: "",
      password: "",
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
        .then((response) => (this.formData = response.data.data));
      //   items.value = data;

      //   console.log(this.formData);
    },
    updateUsers() {
      let token = JSON.parse(localStorage.getItem("token"));

      let dataEdit = new FormData();
      dataEdit.append("id", this.formData.id);
      dataEdit.append("full_name", this.formData.full_name);
      dataEdit.append("email", this.formData.email);
      dataEdit.append("phone", this.formData.phone);
      dataEdit.append("address", this.formData.address);
      dataEdit.append("date_ofbirth", this.formData.date_ofbirth);
      dataEdit.append("status", this.formData.status);
      dataEdit.append("password", this.password);
      dataEdit.append("file", this.file);
      if (this.province.id) {
        dataEdit.append("province_id", this.province.id);
      } 
      if (this.formData.regency_name.id) {
        dataEdit.append("regency_id", this.formData.regency_name.id);
      } 
      console.log(this.formData);
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
