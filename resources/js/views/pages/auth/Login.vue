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
            <span class="text-600 font-medium">Đăng nhập để tiếp tục</span>
          </div>
          <div class="flex align-items-center justify-content-center mt-5">
            <a href="#" class="social-login-link"><i class="pi pi-facebook"></i></a>
            <a href="#" class="social-login-link"><i class="pi pi-twitter"></i></a>
            <a href="#" class="social-login-link"><i class="pi pi-google"></i></a>
          </div>
          <div>
            <form @submit.prevent="login">
              <label for="email1" class="block text-900 text-xl font-medium mb-2">Email</label>
              <InputText name="email" type="email" placeholder="Địa chỉ Email" class="w-full md:w-30rem mb-5"
                style="padding: 1rem" v-model="email" />
              <label for="password" class="block text-900 text-xl font-medium mb-2">Mật khẩu</label>
              <InputText name="password" type="password" placeholder="Mật khẩu" class="w-full md:w-30rem mb-5"
                style="padding: 1rem" v-model="password" />
              <div class="flex align-items-center justify-content-between mb-5 gap-5">
                <div class="flex align-items-center">
                  <input class="form-check-input me-1 mr-2" type="checkbox" id="firstCheckboxStretched">
                  <label for="rememberme1">Nhớ mật khẩu</label>
                </div>
                <RouterLink to="/forgotpassword"><a class="font-medium no-underline ml-2 text-right cursor-pointer"
                    style="color: var(--primary-color)">Bạn quên mật khẩu ?</a></RouterLink>
              </div>
              <button class="w-full p-3 text-xl btn btn-primary">Đăng nhập</button>
            </Form>
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
  // Các phần khác của component
  methods: {
    login() {
      const formData = {
        email: this.email,
        password: this.password,
      };
      axios.post('http://127.0.0.1:8000/api/login', formData)
        .then(response => {
          // Xử lý phản hồi thành công
          const { user, authorization } = response.data;
          // Lưu token vào localStorage hoặc Vuex
          localStorage.setItem('token', authorization.token);
          localStorage.setItem('user', JSON.stringify(user));
          this.$router.push({ name: 'dashboard' });
        })
        .catch(error => {
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

.social-login-link {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 4rem;
  height: 4rem;
  font-size: 1.5rem;
  border-radius: 50%;
  background-color: #f1f1f1;
  color: #333;
  margin-right: 0.5rem;
  transition: background-color 0.2s ease-in-out;
}
</style>

