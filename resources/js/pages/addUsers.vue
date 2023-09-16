

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
                name: ref(''),
                email: ref(''),
                phone: ref(),
                password: ref(),
                checkbox: ref(false)
            },


        }
    },
    methods: {
        storeUsers() {
            //init formData
            let token = JSON.parse(localStorage.getItem('token'));
            // let formData = new FormData();
            var data = {
                name: this.formData.name,
                email: this.formData.email,
                phone: this.formData.phone,
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
                            setInterval(() => {
                            }, 2000).then(this.$swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Login successfully',
                                showConfirmButton: false,
                                timer: 1500
                            }));


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
