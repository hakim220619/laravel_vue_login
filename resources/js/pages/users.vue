<template>
    <EasyDataTable show-index v-model:items-selected="itemsSelected" buttons-pagination :headers="headers" :items="items"
        :loading="loading">

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
                <img src="./images/delete.png" class="operation-icon" @click="deleteItem(item)" />
                <img src="./images/edit.png" class="operation-icon" @click="editItem(item)" />
            </div>
        </template>
    </EasyDataTable>

    <div class="edit-item" v-if="isEditing">
        height:<input type="text" v-model="editingItem.height" />
        <br />
        weight:<input type="text" v-model="editingItem.weight" />
        <br />
        <button @click="submitEdit">ok</button>
    </div>
</template>
<script lang="ts">
import axios from "axios";
import { defineComponent, reactive, ref } from "vue";
import { Header, Item } from "vue3-easy-data-table";
export default defineComponent({
    components: {},
    async mounted() {
        await this.getData();

    },
    methods: {
        async getData() {
            let token = JSON.parse(localStorage.getItem('token'));
            const data = await axios.get(
                'http://127.0.0.1:8000/api/users', {
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token

                }
            }
            ).then((response) => this.DataUsers = response.data.data
            );
            this.DataUsers = data
        },
    },

    setup() {

        const headers: Header[] = [
            { text: "Id", value: "id" },
            { text: "Name", value: "name" },
            { text: "Email", value: "email" },

            { text: "Operation", value: "operation" },
        ];
        const items = ref<Item[]>([]);
        const loading = ref(true);
        setTimeout(async () => {
            loading.value = false;
            let token = JSON.parse(localStorage.getItem('token'));
            const data = await axios.get(
                'http://127.0.0.1:8000/api/users', {
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token

                }
            }
            ).then((response) => response.data.data
            );
            items.value = data;

            console.log(data);



        }, 2000);

        const isEditing = ref(false);
        const editingItem = reactive({
            height: "",
            weight: "",
            id: 0,
        });

        const deleteItem = (val: Item) => {
            items.value = items.value.filter((item) => item.id !== val.id);
        };

        const editItem = (val: Item) => {
            isEditing.value = true;
            const { height, weight, id } = val;
            editingItem.height = height;
            editingItem.weight = weight;
            editingItem.id = id;
        };

        const submitEdit = () => {
            isEditing.value = false;
            const item = items.value.find((item) => item.id === editingItem.id);
            item.height = editingItem.height;
            item.weight = editingItem.weight;
        };

        return {
            DataUsers: [],
            loading,
            submitEdit,
            headers,
            items,
            deleteItem,
            editItem,
            editingItem,
            isEditing,
        };
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
  