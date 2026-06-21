import { Link } from '@inertiajs/react';
import { PropsWithChildren } from 'react';

export default function Guest({ children }: PropsWithChildren) {
    return (
        <div className="flex min-h-screen flex-col items-center justify-center bg-cafe-cream px-4 py-8 font-sans">
            <div className="w-full sm:max-w-md">
                <div className="flex flex-col items-center mb-8">
                    <Link href="/" className="flex flex-col items-center group">
                        <div className="w-16 h-16 rounded-full bg-gradient-to-br from-cafe-green to-cafe-green-dark flex items-center justify-center text-white text-3xl shadow-green transition-transform duration-300 group-hover:scale-105">
                            <i className="fa-solid fa-mug-hot"></i>
                        </div>
                        <span className="mt-3 text-2xl font-bold text-cafe-brown-dark tracking-wide">บรรจงคาเฟ่</span>
                        <span className="text-xs text-cafe-green tracking-widest uppercase font-semibold">Banjong Cafe</span>
                    </Link>
                </div>

                <div className="w-full overflow-hidden bg-white/95 border border-cafe-beige/65 px-8 py-8 shadow-cafe rounded-2xl">
                    {children}
                </div>
            </div>
        </div>
    );
}
