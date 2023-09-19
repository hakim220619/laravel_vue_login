

<template>
    <div>
        <VRow>
            <VCol cols="12" md="12">
                <VCard title="Edit Users">
                    <VCardText>
                        <VForm @submit.prevent="updateUsers()">
                            <VRow>
                                <VCol cols="6">
                                    <VTextField v-model="formData.name" prepend-inner-icon="bx-user" label="First Name"
                                        placeholder="John" />
                                </VCol>

                                <VCol cols="6">
                                    <VTextField v-model="formData.email" prepend-inner-icon="bx-envelope" label="Email"
                                        type="email" placeholder="johndoe@example.com" />
                                </VCol>

                                <VCol cols="6">
                                    <VTextField v-model="formData.phone" prepend-inner-icon="bx-mobile" label="Mobile"
                                        placeholder="+1 123 456 7890" type="number" />
                                </VCol>

                                <VCol cols="6">
                                    <VTextField v-model="formData.password" prepend-inner-icon="bx-lock" label="Password"
                                        type="password" placeholder="············" />
                                </VCol>



                                <VCol cols="12">
                                    <VBtn type="submit" class="me-2">
                                        Submit
                                    </VBtn>

                                    <VBtn color="secondary" to="/users" variant="tonal">
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
import axios from 'axios';
import { useRouter } from 'vue-router';
const router = useRouter();


export default {
    props: ["id"],

    data() {



        return {

            formData: [],


        }
    },
    mounted: function () {
        this.$nextTick(this.getUsersEdit)
    },
    methods: {

        async getUsersEdit() {
            //init formData
            let token = JSON.parse(localStorage.getItem('token'));
            const data = await axios.get(
                'http://127.0.0.1:8000/api/showUsers/' + this.$route.query.id, {
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token

                }
            }
            ).then((response) => this.formData = response.data.data
            );
            // items.value = data;

            // console.log(data);


        },
        updateUsers() {
            let token = JSON.parse(localStorage.getItem('token'));
            var dataEdit = {
                name: this.formData.name,
                email: this.formData.email,
                phone: this.formData.phone,
                password: this.formData.password,
            }
            console.log(this.formData);
            //init formData

            const data = axios.post(
                'http://127.0.0.1:8000/api/updateUsers/', dataEdit, {
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token

                }
            }
            ).then((response) => response.data.data
            );
            // items.value = data;

            // console.log(data);


        }
    }
};
</script>
