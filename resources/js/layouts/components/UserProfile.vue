<script setup>
import avatar1 from "@images/avatars/avatar-1.png";
</script>

<template>
  <VBadge
    dot
    location="bottom right"
    offset-x="3"
    offset-y="3"
    color="success"
    bordered
  >
    <VAvatar class="cursor-pointer" color="primary" variant="tonal">
      <VImg :src="avatar1" />

      <!-- SECTION Menu -->
      <VMenu activator="parent" width="230" location="bottom end" offset="14px">
        <VList>
          <!-- 👉 User Avatar & Name -->
          <VListItem>
            <template #prepend>
              <VListItemAction start>
                <VBadge
                  dot
                  location="bottom right"
                  offset-x="3"
                  offset-y="3"
                  color="success"
                >
                  <VAvatar color="primary" variant="tonal">
                    <VImg :src="avatar1" />
                  </VAvatar>
                </VBadge>
              </VListItemAction>
            </template>

            <VListItemTitle class="font-weight-semibold">
              {{ getUsers.full_name }}
            </VListItemTitle>
            <VListItemSubtitle>Admin</VListItemSubtitle>
          </VListItem>
          <VDivider class="my-2" />

          <!-- 👉 Profile -->
          <VListItem link>
            <template #prepend>
              <VIcon class="me-2" icon="bx-user" size="22" />
            </template>

            <VListItemTitle>Profile</VListItemTitle>
          </VListItem>

          <!-- 👉 Settings -->
          <VListItem link>
            <template #prepend>
              <VIcon class="me-2" icon="bx-cog" size="22" />
            </template>

            <VListItemTitle>Settings</VListItemTitle>
          </VListItem>

          <!-- 👉 Pricing -->
          <VListItem link>
            <template #prepend>
              <VIcon class="me-2" icon="bx-dollar" size="22" />
            </template>

            <VListItemTitle>Pricing</VListItemTitle>
          </VListItem>

          <!-- 👉 FAQ -->
          <VListItem link>
            <template #prepend>
              <VIcon class="me-2" icon="bx-help-circle" size="22" />
            </template>

            <VListItemTitle>FAQ</VListItemTitle>
          </VListItem>

          <!-- Divider -->
          <VDivider class="my-2" />

          <!-- 👉 Logout -->
          <VListItem @click="logout">
            <template #prepend>
              <VIcon class="me-2" icon="bx-log-out" size="22" />
            </template>

            <VListItemTitle>Logout</VListItemTitle>
          </VListItem>
        </VList>
      </VMenu>
      <!-- !SECTION -->
    </VAvatar>
  </VBadge>
</template>
<script></script>
<script>
import axios from "axios";
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";

export default {
  data() {
    const store = useStore();

    const getUsers = computed(() => {
      return store.getters.getUsers.data;
    });

    onMounted(() => {
      store.dispatch("fetchUsers");
    });
    return {
      getUsers,
    };
  },

  methods: {
    logout() {
      let timerInterval;
      this.$swal
        .fire({
          title: "",
          html: "Loading...",
          timer: 1000,
          timerProgressBar: true,
          didOpen: () => {
            this.$swal.showLoading();
            let token = JSON.parse(localStorage.getItem("token"));
            // console.log(token);
            axios
              .get("http://localhost:8000/api/logout", {
                headers: {
                  Accept: "application/json",
                  Authorization: "Bearer " + token,
                },
              })
              .then((response) => this.$router.push({ name: "login" }))
              .catch((err) => console.log(err))
              .finally(() => {
                (this.loading = false),
                  this.$swal.fire({
                    icon: "success",
                    title: "Logout berhasil!!!",
                    showConfirmButton: true,
                    timer: 1500,
                  }),
                  localStorage.clear();
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
