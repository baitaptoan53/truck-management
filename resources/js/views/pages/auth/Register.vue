<script setup>
import { useLayout } from '@/layout/composables/layout';
import { ref, computed } from 'vue';
import AppConfig from '@/layout/AppConfig.vue';

const { layoutConfig } = useLayout();
const logoUrl = computed(() => {
    return `layout/images/${layoutConfig.darkTheme.value ? 'logo-white' : 'logo-dark'}.svg`;
});
</script>

<template>
    <div class="surface-ground flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden">
        <div class="flex flex-column align-items-center justify-content-center">
            <div
                style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
                <div class="w-full surface-card py-8 px-5 sm:px-8" style="border-radius: 53px">
                    <div class="text-center mb-5">
                        <img src="/demo/images/login/avatar.png" alt="Image" height="50" class="mb-3" />
                        <div class="text-900 text-3xl font-medium mb-3">Welcome, TRUCK NPN!</div>
                    </div>
                    <div>
                        <form @submit.prevent="register">
                            <label for="email1" class="block text-900 text-xl font-medium mb-2">Email</label>
                            <InputText v-model="email" name="email" type="email" placeholder="Email address"
                                class="w-full md:w-30rem mb-5" style="padding: 1rem" />
                            <label for="name" class="block text-900 text-xl font-medium mb-2">Họ và tên</label>
                            <InputText v-model="name" name="name" type="name" placeholder="Họ và tên"
                                class="w-full md:w-30rem mb-5" style="padding: 1rem" />
                            <label for="phone" class="block text-900 text-xl font-medium mb-2">Số điện thoại</label>
                            <InputText v-model="phone" name="phone" type="number" placeholder="Số điện thoại"
                                class="w-full md:w-30rem mb-5" style="padding: 1rem" />
                            <label for="password" class="block text-900 text-xl font-medium mb-2">Mật khẩu</label>
                            <Password id="password1" v-model="password" placeholder="Mật khẩu" :toggleMask="true"
                                class="w-full mb-3" inputClass="w-full" inputStyle="padding:1rem"></Password>
                            <div class="flex align-items-center justify-content-between mb-5 gap-5">
                                <RouterLink to="/login">
                                    <a class="font-medium no-underline ml-2 text-right cursor-pointer"
                                        style="color: var(--primary-color)">Bạn đã có tài khoản ?</a>
                                </RouterLink>
                            </div>
                            <button label="Đăng Ký" class="w-full p-3 text-xl">Đăng Ký</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <AppConfig simple />
</template>
<script>
import axios from 'axios';

export default {
    methods: {
        register() {
            const formData = {
                email: this.email,
                password: this.password,
                name: this.name,
                phone: this.phone
            };

            axios.post('http://127.0.0.1:8000/api/register', formData)
                .then(response => {
                    // Xử lý phản hồi thành công
                    console.log(response.data);
                    // Chuyển hướng hoặc làm bất kỳ điều gì sau khi đăng ký thành công
                    this.$router.push({ name: 'login' });
                })
                .catch(error => {
                    // Xử lý lỗi
                    console.log(formData);
                    this.error = error.response.data.message;
                });
        }
    }
};
</script>
<style scoped>
.pi-eye {
    transform: scale(1.6);
    margin-right: 1rem;
}

.pi-eye-slash {
    transform: scale(1.6);
    margin-right: 1rem;
}
</style>
