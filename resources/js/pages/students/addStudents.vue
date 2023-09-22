

<template>
    <div>
        <VRow>
            <VCol cols="12" md="12">
                <VCard title="Add Users">
                    <VCardText>
                        <form @submit="formSubmit" enctype="multipart/form-data">
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
                                    <VTextField v-on:change="onChange" prepend-inner-icon="bx-images" label="Image"
                                        type="file" />


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
                        </form>
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
            file: '',
            formData: [],
            classData: [],
            majorData: [],

        }
    },
    mounted() {
        this.$nextTick().then(this.getClass);
        this.$nextTick().then(this.getMajor);
    },
    methods: {
        onChange(e) {
            this.file = e.target.files[0];
        },
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

        formSubmit(e) {
            e.preventDefault();
            let token = JSON.parse(localStorage.getItem('token'));
            let data = new FormData();
            data.append('nisn', this.formData.nisn);
            data.append('full_name', this.formData.full_name);
            data.append('email', this.formData.email);
            data.append('phone', this.formData.phone);
            data.append('address', this.formData.address);
            data.append('date_ofbirth', this.formData.date_ofbirth);
            data.append('class', this.formData.class.id);
            data.append('major', this.formData.major.id);
            data.append('password', this.formData.password);
            data.append('file', this.file);
            console.log(data);
            let timerInterval
            this.$swal.fire({
                title: '',
                html: 'Loading...',
                timer: 3000,
                timerProgressBar: true,
                didOpen: () => {
                    this.$swal.showLoading()
                    axios
                        .post('http://localhost:8000/api/addStudents', data, {
                            headers: {
                                Accept: "application/json",
                                'Content-Type': 'multipart/form-data',
                                Authorization: "Bearer " + token
                            }
                        }).then(response => (
                            // console.log(response.data.token),

                            this.$router.push({ name: 'students' })
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
    },


};
</script>
