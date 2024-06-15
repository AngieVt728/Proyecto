export interface User {
    id: number;
    first_name: string;
    last_name: string;
    ci: string;
    contact: string;
    address: string;
    username: string;
    email: string;
    email_verified_at: string;
    avatar: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    auth: {
        user: User;
        roles: string[];
        permissions: string[];
    };
};
