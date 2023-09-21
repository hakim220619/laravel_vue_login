

<template>
    <div>
        <VRow>
            <VCol cols="12" md="12">
                <VCard title="Add Users">
                    <VCardText>
                        <VForm @submit.prevent="storeUsers()">
                            <VRow>
                                <VCol cols="6">
                                    <VTextField v-model="formData.nisn" prepend-inner-icon="bx-user" label="Nisn"
                                        type="number" placeholder="2313***" />
                                </VCol>
                                <VCol cols="6">
                                    <VTextField v-model="formData.full_name" prepend-inner-icon="bx-user" label="First Name"
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
                                    <VTextField v-model="formData.address" prepend-inner-icon="bx-location-plus"
                                        label="Address" placeholder="Jl *******" type="text" />
                                </VCol>
                                <VCol cols="6">
                                    <VTextField v-model="formData.image" prepend-inner-icon="bx-location-plus" label="Image"
                                        placeholder="Image" type="file" />
                                </VCol>
                                <VCol cols="6">
                                    <VTextField v-model="formData.date_ofbirth" prepend-inner-icon="bx-calendar"
                                        label="Date" type="date" />
                                </VCol>
                                <VCol cols="6">
                                    <v-select v-model="formData.class" :items="classData" item-title="class_name"
                                        item-value="id" label="Class" placeholder="Select Class"
                                        prepend-inner-icon="bx-home" return-object></v-select>

                                </VCol>
                                <VCol cols="6">
                                    <v-select v-model="formData.major" :items="majorData" item-title="major_name"
                                        item-value="id" label="Major" placeholder="Select Major"
                                        prepend-inner-icon="bx-home" return-object></v-select>

                                </VCol>



                                <VCol cols="6">
                                    <VTextField v-model="formData.password" prepend-inner-icon="bx-lock" label="Password"
                                        type="password" placeholder="············" />
                                </VCol>



                                <VCol cols="12">
                                    <VBtn type="submit" class="me-2">
                                        Submit
                                    </VBtn>

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
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();


export default {

    data() {

        return {
            formData: {
                full_name: ref(''),
                email: ref(''),
                phone: ref(''),
                class: ref(''),
                password: ref(''),
                checkbox: ref(false)
            },

            classData: [],
            majorData: [],


        }
    },
    mounted() {
        this.$nextTick().then(this.getClass);
        this.$nextTick().then(this.getMajor);
    },
    methods: {
        getClass() {
            //init formData
            let token = JSON.parse(localStorage.getItem('token'));
            const data = axios.get(
                'http://127.0.0.1:8000/api/getClass', {
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token

                }
            }
            ).then((response) => this.classData = response.data.data)
        },
        getMajor() {
            //init formData
            let token = JSON.parse(localStorage.getItem('token'));
            const data = axios.get(
                'http://127.0.0.1:8000/api/getMajor', {
                headers: {
                    Accept: "application/json",
                    Authorization: "Bearer " + token

                }
            }
            ).then((response) => this.majorData = response.data.data)
        },
        storeUsers() {
            //init formData
            let token = JSON.parse(localStorage.getItem('token'));
            // let formData = new FormData();
            // console.log(formData);
            var data = {
                full_name: this.formData.full_name,
                email: this.formData.email,
                phone: this.formData.phone,
                class: this.formData.class.id,
                major: this.formData.major.id,
                date_ofbirth: this.formData.date_ofbirth,
                image: this.formData.image,
                password: this.formData.password,
            }
            console.log(data);
            //assign state value to formData
            // formData.append("name", name.value);
            // formData.append("email", email.value);
            // formData.append("phone", phone.value);
            // formData.append("password", password.value);

            //store data with API


            let timerInterval
            this.$swal.fire({
                title: '',
                html: 'Loading...',
                timer: 3000,
                timerProgressBar: true,
                didOpen: () => {
                    this.$swal.showLoading()
                    axios
                        .post('http://localhost:8000/api/addUsers', data, {
                            headers: {
                                Accept: "application/json",
                                Authorization: "Bearer " + token
                            }
                        }).then(response => (
                            // console.log(response.data.token),

                            this.$router.push({ name: 'users' })
                        ))
                        .catch(err => console.log(err))
                        .finally(() => {
                            const Toast = this.$swal.mixin(
                                {
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,

                                })
                            Toast.fire({
                                icon: "success",
                                title: "Insert Users Success..",
                            });


                        })
                },
                willClose: () => {

                    clearInterval(timerInterval)
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {

                }
            })
        }
    }
};
</script>
