<template>
  <MasterData></MasterData>
  <!-- <h3>Users</h3> -->
  <VRow>
    <VCol cols="12" md="12">
      <!-- 👉 Horizontal Form -->
      <VCard title="">
        <VCardText>
          <VBtn class="text-end" to="/addUsers">Add</VBtn>
        </VCardText>

        <VCardText>
          <EasyDataTable
            show-index
            buttons-pagination
            :headers="headers"
            :rows-per-page="10"
            :items="items"
            :loading="loading"
            theme-color="#1d90ff"
          >
            <!-- <img src="./images/delete.png" style="width: 60px; height: 100px" /> -->
            <!-- <Loading></Loading> -->

            <template #item-player="{ player, avator, page }">
              <div class="player-wrapper">
                <img class="avator" :src="avator" alt="" />
                <a target="_blank" :href="page">{{ player }}</a>
              </div>
            </template>
            <template #item-team="{ teamName, teamUrl }">
              <a target="_blank" :href="teamUrl">{{ teamName }}</a>
            </template>
            <template #item-operation="item">
              <div class="operation-wrapper">
                <!-- <img src="./images/delete.png" class="operation-icon" @click="getListings()" /> -->
                <img
                  src="./images/delete.png"
                  class="operation-icon"
                  @click="deleteItem(item)"
                />
                <img
                  src="./images/edit.png"
                  class="operation-icon"
                  @click="editItem(item)"
                />
              </div>
            </template>
          </EasyDataTable>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
<script lang="ts">
import MasterData from "@/views/pages/master-data/masterData.vue";
import axios from "axios";
import Swal from "sweetalert2";
import { defineComponent, onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import { Header, Item } from "vue3-easy-data-table";
const router = useRoute();
export default defineComponent({
  components: { MasterData },

  setup() {
    const headers: Header[] = [
      // { text: "Id", value: "id" },
      { text: "Name", sortable: true, value: "full_name" },
      { text: "Phone", sortable: true, value: "phone" },
      { text: "Email", sortable: true, value: "email" },
      { text: "Status", sortable: true, value: "status" },
      { text: "Role", sortable: true, value: "role_name" },
      { text: "Action", value: "operation" },
    ];
    const items = ref<Item[]>([]);
    const loading = ref(true);
    onMounted(() => {
      ShowData();
    });
    async function ShowData() {
      setTimeout(async () => {
        loading.value = false;
        let token = JSON.parse(localStorage.getItem("token"));
        const data = await axios
          .get("http://127.0.0.1:8000/api/users", {
            headers: {
              Accept: "application/json",
              Authorization: "Bearer " + token,
            },
          })
          .then((response) => response.data.data);
        items.value = data;

        // console.log(data);
      }, 500);
    }

    const isEditing = ref(false);

    const deleteItem = (val: Item) => {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          setTimeout(async () => {
            let token = JSON.parse(localStorage.getItem("token"));
            const data = await axios
              .get("http://127.0.0.1:8000/api/users/delete/" + val.id, {
                headers: {
                  Accept: "application/json",
                  Authorization: "Bearer " + token,
                },
              })
              .then((response) => response.data.data);
          }, 500);
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
          });
          Toast.fire({
            icon: "success",
            title: "Delete Users Success..",
          });
          items.value = items.value.filter((item) => item.id !== val.id);
        }
      });
    };

    return {
      DataUsers: [],
      getStatus: ["ON", "OFF"],
      loading,
      headers,
      items,
      deleteItem,
      ShowData,
      isEditing,
    };
  },
  methods: {
    editItem: function (val: Item) {
      this.$router.push({ path: "editUsers", query: { id: val.id } });
    },
  },
});
</script>

<style>
.operation-wrapper .operation-icon {
  width: 20px;
  cursor: pointer;
}

.player-wrapper {
  padding: 5px;
  display: flex;
  align-items: center;
  justify-items: center;
}

.avator {
  margin-right: 10px;
  display: inline-block;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  box-shadow: inset 0 2px 4px 0 rgb(0 0 0 / 10%);
}
</style>
