<script setup>
import { useLayout } from '@/layout/composables/layout';
import { ref, computed } from 'vue';
import AppConfig from '@/layout/AppConfig.vue';

const { layoutConfig } = useLayout();
const email = ref('');
const password = ref('');
const checked = ref(false);

const logoUrl = computed(() => {
    return `layout/images/${layoutConfig.darkTheme.value ? 'logo-white' : 'logo-dark'}.svg`;
});
</script>

<template>
    <div class="surface-ground flex align-items-center justify-content-center min-h-screen min-w-screen overflow-hidden">
        <div class="flex flex-column align-items-center justify-content-center">
            <div style="border-radius: 56px; padding: 0.3rem; background: linear-gradient(180deg, var(--primary-color) 10%, rgba(33, 150, 243, 0) 30%)">
                <div class="w-full surface-card py-8 px-5 sm:px-8" style="border-radius: 53px">
                    <div class="text-center mb-5">
                        <img src="/demo/images/login/avatar.png" alt="Image" height="50" class="mb-3" />
                        <div class="text-900 text-3xl font-medium mb-3">Welcome, TRUCK NPN!</div>
                    </div>

                    <div>
                              <form >
                                             <label for="email1" class="block text-900 text-xl font-medium mb-2">Email</label>
                                             <InputText id="email1" type="email" placeholder="Email address" class="w-full md:w-30rem mb-5" style="padding: 1rem" v-model="email" />
                                             <label for="Phone" class="block text-900 text-xl font-medium mb-2">Số điện thoại</label>
                                             <InputText id="Phone" type="Phone" placeholder="Phone" class="w-full md:w-30rem mb-5" style="padding: 1rem" v-model="Phone" />
                                             <label for="password1" class="block text-900 font-medium text-xl mb-2">Mật khẩu</label>
                                             <Password id="password1" v-model="password" placeholder="Password" class="w-full mb-3" inputClass="w-full" inputStyle="padding:1rem" toggleMask></Password>
                                             <label for="password1" class="block text-900 font-medium text-xl mb-2">Xác nhận mật khẩu</label>
                                             <Password id="password2" v-model="password_confirmation" placeholder="Password" class="w-full mb-3" inputClass="w-full" inputStyle="padding:1rem" toggleMask></Password>
                                             <small class="p-error" id="password-error">{{password_confirmation !== password ? 'Mật khẩu không trùng khớp' : ''}}</small>
                                             <div class="flex align-items-center justify-content-between mb-5 gap-5">
                                             <div class="flex align-items-center">
                                             </div>
                                             <RouterLink to="/login">

                                                            <a class="font-medium no-underline ml-2 text-right cursor-pointer" style="color: var(--primary-color)">Bạn đã có tài khoản ?</a>
                                             </RouterLink>
                                             </div>
                                             <Button label="Register" class="w-full p-3 text-xl"></Button>
                              </form>
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
    <AppConfig simple />
</template>

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
