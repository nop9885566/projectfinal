import { ButtonHTMLAttributes } from 'react';

export default function PrimaryButton({
    className = '',
    disabled,
    children,
    ...props
}: ButtonHTMLAttributes<HTMLButtonElement>) {
    return (
        <button
            {...props}
            className={
                `inline-flex items-center rounded-full border border-transparent bg-cafe-green px-5 py-2.5 text-sm font-medium tracking-wide text-white transition duration-150 ease-in-out hover:bg-cafe-green-dark focus:bg-cafe-green-dark focus:outline-none focus:ring-2 focus:ring-cafe-green focus:ring-offset-2 active:bg-cafe-green-dark shadow-green ${
                    disabled && 'opacity-25'
                } ` + className
            }
            disabled={disabled}
        >
            {children}
        </button>
    );
}
