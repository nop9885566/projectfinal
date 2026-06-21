import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

export default function Login({
    status,
    canResetPassword,
}: {
    status?: string;
    canResetPassword: boolean;
}) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false as boolean,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Log in" />

            {status && (
                <div className="mb-4 text-sm font-medium text-green-600">
                    {status}
                </div>
            )}

            <form onSubmit={submit}>
                <div>
                    <InputLabel htmlFor="email" value="อีเมล (Email)" className="text-cafe-brown-dark font-medium" />

                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="mt-1 block w-full"
                        autoComplete="username"
                        isFocused={true}
                        onChange={(e) => setData('email', e.target.value)}
                    />

                    <InputError message={errors.email} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password" value="รหัสผ่าน (Password)" className="text-cafe-brown-dark font-medium" />

                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="mt-1 block w-full"
                        autoComplete="current-password"
                        onChange={(e) => setData('password', e.target.value)}
                    />

                    <InputError message={errors.password} className="mt-2" />
                </div>

                <div className="mt-4 block">
                    <label className="flex items-center cursor-pointer">
                        <Checkbox
                            name="remember"
                            checked={data.remember}
                            className="rounded border-gray-300 text-cafe-green focus:ring-cafe-green"
                            onChange={(e) =>
                                setData(
                                    'remember',
                                    (e.target.checked || false) as false,
                                )
                            }
                        />
                        <span className="ms-2 text-sm text-cafe-brown-dark/80">
                            จดจำการเข้าระบบของฉัน
                        </span>
                    </label>
                </div>

                <div className="mt-6 flex items-center justify-between">
                    {canResetPassword ? (
                        <Link
                            href={route('password.request')}
                            className="rounded-md text-sm text-cafe-green hover:text-cafe-green-dark underline focus:outline-none"
                        >
                            ลืมรหัสผ่าน?
                        </Link>
                    ) : (
                        <div />
                    )}

                    <PrimaryButton disabled={processing}>
                        เข้าสู่ระบบ
                    </PrimaryButton>
                </div>

                <div className="mt-8 border-t border-cafe-beige/40 pt-4 text-center text-sm text-cafe-brown-dark/70">
                    ยังไม่มีบัญชีสมาชิก?{' '}
                    <Link
                        href={route('register')}
                        className="text-cafe-green hover:text-cafe-green-dark underline font-semibold"
                    >
                        สมัครสมาชิกใหม่ที่นี่
                    </Link>
                </div>
            </form>
        </GuestLayout>
    );
}
