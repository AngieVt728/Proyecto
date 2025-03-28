import { PageProps } from "@/types";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const pageProps = computed(() => usePage<PageProps>().props);
const auth = computed(() => pageProps.value.auth);
const user = computed(() => auth.value.user);

export const getUser = () => {
    return user.value;
};

export const getFullName = () => {
    return `${user.value.first_name} ${user.value.last_name}`;
};

export const getUsername = () => {
    return user.value.username;
};

export const getRole = () => {
    return auth.value.roles[0];
};
