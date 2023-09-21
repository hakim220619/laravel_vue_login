
<template>
    <VRow>
        <VCol cols="12" md="12">

            <!-- 👉 Horizontal Form -->
            <VCard title="">
                <VCardText>
                    <VBtn class="text-end" @click="handleClick" v-bind:color="active === true ? 'primary' : 'secondary'"
                        to="/users" style="width: 15%;">Admin
                    </VBtn>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <VBtn class="text-end" color="secondary" to="/students" style="width: 15%;">Siswa</VBtn>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <VBtn class="text-end" color="secondary" to="/addUsers" style="width: 15%;">Kelas</VBtn>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <VBtn class="text-end" color="secondary" to="/addUsers" style="width: 15%;">Alumni</VBtn>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </VCardText>

            </VCard>
        </VCol>
    </VRow>
</template>
<script>
export default {
    data() {

        return {
            active: false,

        };
    },
    methods: {

        handleClick() {
            this.active = !this.active;
            // console.log(this.active);
        },
    },
};
</script>
