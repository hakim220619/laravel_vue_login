

<template>
    <div>
        <VRow>
            <VCol cols="12" md="12">
                <VCard title="Vertical Form with Icons">
                    <VCardText>
                        <VForm @submit.prevent="storeUsers()">
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
                                    <VCheckbox v-model="formData.checkbox" label="Remember me" />
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

            formData: {
                name: this.$nextTick(this.getUsersEdit).name,
                email: this.$nextTick(this.getUsersEdit).email,
                phone: this.$nextTick(this.getUsersEdit).phone,
                password: this.$nextTick(this.getUsersEdit).password,
                checkbox: ref(false),

            },


        }
    },
    mounted: function () {
        let data = this.$nextTick(this.getUsersEdit)
    },
    methods: {

        async getUsersEdit() {
            //init formData
            let token = JSON.parse(localStorage.getItem('token'));

            // let formData = new FormData();
            // let formData = this.data
            // console.log(formData);
            // var dataUsers = {
            //     name: formData.name,
            //     email: formData.email,
            //     phone: formData.phone,
            //     password: formData.password,
            // }
            // console.log(data);
            //assign state value to formData
            // formData.append("name", name.value);
            // formData.append("email", email.value);
            // formData.append("phone", phone.value);
            // formData.append("password", password.value);

            //store data with API



            setTimeout(async () => {
                // loading.value = false;
                let token = JSON.parse(localStorage.getItem('token'));
                const data = await axios.get(
                    'http://127.0.0.1:8000/api/showUsers/' + this.$route.query.id, {
                    headers: {
                        Accept: "application/json",
                        Authorization: "Bearer " + token

                    }
                }
                ).then((response) => response.data.data
                );
                // items.value = data;

                // console.log(data);
            }, 500);

        }
    }
};
</script>
