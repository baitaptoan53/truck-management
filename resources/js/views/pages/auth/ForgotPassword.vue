<script setup>
import { useLayout } from '@/layout/composables/layout';
import { ref, computed } from 'vue';
import AppConfig from '@/layout/AppConfig.vue';
import { Form as VeeForm, Field, ErrorMessage } from 'vee-validate';
import * as yup from 'yup';
const schema = yup.object({
    email: yup.string()
        .required('Email không được bỏ trống')
        .email('Email không hợp lệ'),
});

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
                        <span class="text-600 font-medium">Quên mật khẩu</span>
                    </div>
                    <div>
                        <VeeForm v-slot="{ submitForm }" :validation-schema="schema" as="div">
                            <form @submit="submitForm" method="post" action="/api/users/">
                                <label for="email1" class="block text-900 text-xl font-medium mb-2">Email</label>
                                <Field name="email" type="email" placeholder="Email address" class="w-full md:w-30rem mb-5"
                                    style="padding: 1rem" />
                                <div>
                                    <ErrorMessage name="email" class="text-danger" />
                                </div>
                                <div class="flex align-items-center justify-content-between mb-5 gap-5">
                                    <RouterLink to="/login"><a
                                            class="font-medium no-underline ml-2 text-right cursor-pointer"
                                            style="color: var(--primary-color)">Quay về trang đăng nhập</a></RouterLink>
                                </div>
                                <button class="w-full p-3 text-xl btn btn-primary">Gửi email</button>
                            </Form>
                        </VeeForm>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <AppConfig simple />
</template>
<script>

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
