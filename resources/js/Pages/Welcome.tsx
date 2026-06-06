import { useEffect, useRef, useState } from 'react';
import { Head } from '@inertiajs/react';

/* ─── Types ─────────────────────────────────── */
interface MenuItem { id: number; name: string; desc: string; price: string; badge?: string }
type TabKey = 'coffee' | 'noncoffee' | 'bakery' | 'food';

const MENU: Record<TabKey, MenuItem[]> = {
    coffee: [
        { id: 1,  name: 'Signature Latte',    desc: 'ลาเต้สูตรพิเศษของร้าน นุ่มละมุน หอมกลิ่นนม',          price: '฿75',  badge: 'ยอดนิยม' },
        { id: 2,  name: 'Cold Brew',           desc: 'กาแฟสกัดเย็น 18 ชั่วโมง เข้มข้น สดชื่น',            price: '฿85' },
        { id: 3,  name: 'Double Espresso',     desc: 'เอสเปรสโซ่คู่ เข้มข้น ตื่นตัวได้ทันที',               price: '฿65' },
        { id: 4,  name: 'Caramel Macchiato',   desc: 'คาราเมลหอมหวาน ผสมลาเต้ ราดซอสคาราเมล',              price: '฿90',  badge: 'ใหม่' },
    ],
    noncoffee: [
        { id: 5,  name: 'Matcha Latte',        desc: 'ชาเขียวญี่ปุ่นแท้ ผสมนมสดสูตรเข้มข้น',              price: '฿80',  badge: 'ยอดนิยม' },
        { id: 6,  name: 'ชาไทยนมสด',           desc: 'ชาไทยสูตรต้นตำรับ หอมเครื่องเทศ หวานมัน',           price: '฿65' },
        { id: 7,  name: 'Fruit Soda',          desc: 'โซดาผลไม้สดสดชื่น หลายรสชาติให้เลือก',               price: '฿70' },
        { id: 8,  name: 'Hot Chocolate',       desc: 'ช็อกโกแลตเบลเยี่ยมแท้ เข้มข้น หอมหวาน',             price: '฿75' },
    ],
    bakery: [
        { id: 9,  name: 'Butter Croissant',    desc: 'ครัวซองค์เนยแท้ อบสด กรอบนอก นุ่มใน',              price: '฿55',  badge: 'ยอดนิยม' },
        { id: 10, name: 'Banana Muffin',       desc: 'มัฟฟินกล้วยหอม ช촉촉 นุ่ม หอมหวาน',                  price: '฿45' },
        { id: 11, name: 'Classic Scones',      desc: 'สโคนสูตรอังกฤษ เสิร์ฟพร้อมแยมและครีม',              price: '฿60' },
        { id: 12, name: 'Cinnamon Roll',       desc: 'ซินนาบอนสูตรพิเศษ อบสด หอมอบเชย',                  price: '฿65',  badge: 'ใหม่' },
    ],
    food: [
        { id: 13, name: 'Brunch Set',          desc: 'ไข่ ขนมปัง เบคอน สลัด ครบในจานเดียว',               price: '฿150', badge: 'แนะนำ' },
        { id: 14, name: 'Club Sandwich',       desc: 'แซนวิชหน้าไก่ ชีส มะเขือเทศ เสิร์ฟพร้อมมันฝรั่ง',  price: '฿120' },
        { id: 15, name: 'Creamy Pasta',        desc: 'พาสต้าซอสครีม ไก่ย่าง เห็ด หอมกรุ่น',               price: '฿140' },
        { id: 16, name: 'ข้าวหน้าไก่ย่าง',    desc: 'ข้าวหน้าไก่ย่างสมุนไพร ราดซอสพิเศษ เสิร์ฟร้อน',    price: '฿110' },
    ],
};

const REVIEWS = [
    { name: 'มินิ สาวน้อย',     src: 'Google Maps',   text: 'มาที่นี่ครั้งแรกเลยติดใจ บรรยากาศดีมากๆ วิวทุ่งนาสวยงาม กาแฟหอมอร่อย อยากกลับมาอีกแน่นอน',           initial: 'ม', from: '#7D8F69', to: '#a8c17b' },
    { name: 'ตั้ม วัยทำงาน',    src: 'Facebook',      text: 'WiFi เร็วมาก มีปลั๊กทุกโต๊ะ เหมาะมากสำหรับนั่งทำงาน กาแฟอร่อย บรรยากาศไม่วุ่นวาย ชอบมากครับ',       initial: 'ต', from: '#C8B6A6', to: '#8B6F47' },
    { name: 'นุ่น ครีเอทีฟ',   src: 'Instagram',     text: 'ถ่ายรูปสวยมากทุกมุม เบเกอรี่อร่อยมาก ครัวซองค์กรอบนอกนุ่มใน แนะนำให้ทุกคนมาลองจริงๆ ค่ะ',          initial: 'น', from: '#E8E2D8', to: '#C8B6A6' },
    { name: 'ปลา นักอ่าน',     src: 'Google Maps',   text: 'มานั่งอ่านหนังสือทุกอาทิตย์ บรรยากาศเงียบสงบ พนักงานใจดี กาแฟอร่อย และน้ำเปล่าฟรีบริการด้วย',         initial: 'ป', from: '#7D8F69', to: '#4a6b3a' },
    { name: 'กัน แฟนพันธุ์กาแฟ', src: 'Facebook',   text: 'Signature Latte อร่อยมากที่สุดที่เคยดื่มมา Latte art สวย บรรจงคาเฟ่คือสวรรค์ของคนชอบกาแฟ!',            initial: 'ก', from: '#C8B6A6', to: '#7D8F69' },
];

const GALLERY = [
    { label: 'บรรยากาศร้าน',      tall: true,  bg: 'from-cafe-green-dark to-cafe-green',       emoji: '☕' },
    { label: 'กาแฟพิเศษ',         tall: false, bg: 'from-cafe-brown to-cafe-tan',               emoji: '🫖' },
    { label: 'เบเกอรี่สด',        tall: false, bg: 'from-amber-700 to-amber-400',               emoji: '🥐' },
    { label: 'วิวธรรมชาติ',       tall: true,  bg: 'from-emerald-800 to-emerald-500',           emoji: '🌿' },
    { label: 'เครื่องดื่มหลากหลาย', tall: false, bg: 'from-cafe-green to-cafe-green-light',     emoji: '🧋' },
    { label: 'มุมนั่งทำงาน',      tall: false, bg: 'from-cafe-brown-dark to-cafe-brown',        emoji: '💻' },
];

/* ─── Icon helpers ──────────────────────────── */
const Icon = ({ path, className = 'w-5 h-5' }: { path: string; className?: string }) => (
    <svg className={className} fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.8}>
        <path strokeLinecap="round" strokeLinejoin="round" d={path} />
    </svg>
);

/* ─── Section Tag ────────────────────────────── */
const Tag = ({ children, light = false }: { children: string; light?: boolean }) => (
    <span className={`inline-block text-xs font-semibold tracking-[0.15em] uppercase px-4 py-1.5 rounded-full mb-3
        ${light ? 'text-white/80 bg-white/15' : 'text-cafe-green bg-cafe-green/10'}`}>
        {children}
    </span>
);

/* ─── Menu Card ─────────────────────────────── */
const MenuCard = ({ item, onAdd }: { item: MenuItem; onAdd: () => void }) => {
    const badgeColor = item.badge === 'ใหม่' ? 'bg-cafe-brown' : 'bg-cafe-green';
    return (
        <div className="group bg-white rounded-2xl overflow-hidden border border-cafe-beige shadow-sm
                        hover:-translate-y-2 hover:shadow-cafe transition-all duration-500">
            {/* Image placeholder */}
            <div className="relative h-44 bg-gradient-to-br from-cafe-cream to-cafe-beige flex items-center
                            justify-center overflow-hidden">
                <span className="text-5xl select-none group-hover:scale-110 transition-transform duration-500">
                    {item.id <= 4 ? '☕' : item.id <= 8 ? '🧋' : item.id <= 12 ? '🥐' : '🍽️'}
                </span>
                {item.badge && (
                    <span className={`absolute top-3 left-3 ${badgeColor} text-white text-[10px] font-semibold
                                     px-3 py-1 rounded-full tracking-wide`}>
                        {item.badge}
                    </span>
                )}
            </div>
            <div className="p-5">
                <h3 className="text-cafe-brown-dark font-semibold text-base mb-1.5">{item.name}</h3>
                <p className="text-gray-400 text-xs leading-relaxed mb-4">{item.desc}</p>
                <div className="flex items-center justify-between">
                    <span className="text-cafe-green-dark font-bold text-lg">{item.price}</span>
                    <button id={`add-${item.id}`}
                        onClick={onAdd}
                        className="w-9 h-9 rounded-full bg-cafe-green text-white flex items-center justify-center
                                   hover:bg-cafe-green-dark hover:scale-110 hover:rotate-90
                                   transition-all duration-300 shadow-green"
                        aria-label={`เพิ่ม ${item.name}`}>
                        <Icon path="M12 4.5v15m7.5-7.5h-15" className="w-4 h-4" />
                    </button>
                </div>
            </div>
        </div>
    );
};

/* ─── Main Component ────────────────────────── */
export default function Welcome() {

    /* State */
    const [loading,    setLoading]    = useState(true);
    const [scrolled,   setScrolled]   = useState(false);
    const [mobileOpen, setMobileOpen] = useState(false);
    const [activeTab,  setActiveTab]  = useState<TabKey>('coffee');
    const [toast,      setToast]      = useState(false);
    const [showTop,    setShowTop]    = useState(false);
    const [activeSection, setActiveSection] = useState('home');

    const navRef    = useRef<HTMLElement>(null);
    const toastRef  = useRef<ReturnType<typeof setTimeout>>();

    /* Loading */
    useEffect(() => {
        const t = setTimeout(() => setLoading(false), 2000);
        return () => clearTimeout(t);
    }, []);

    /* Scroll events */
    useEffect(() => {
        const onScroll = () => {
            setScrolled(window.scrollY > 50);
            setShowTop(window.scrollY > 500);
            // Active section detection
            const sectionIds = ['home','about','menu','gallery','promotions','reviews','contact'];
            for (let i = sectionIds.length - 1; i >= 0; i--) {
                const el = document.getElementById(sectionIds[i]);
                if (el && window.scrollY >= el.offsetTop - 130) {
                    setActiveSection(sectionIds[i]);
                    break;
                }
            }
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        return () => window.removeEventListener('scroll', onScroll);
    }, []);

    /* Intersection Observer for fade-in */
    useEffect(() => {
        if (loading) return;
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    (e.target as HTMLElement).style.opacity = '1';
                    (e.target as HTMLElement).style.transform = 'none';
                    obs.unobserve(e.target);
                }
            });
        }, { threshold: 0.12 });
        document.querySelectorAll('[data-reveal]').forEach(el => {
            (el as HTMLElement).style.opacity = '0';
            (el as HTMLElement).style.transform = 'translateY(28px)';
            (el as HTMLElement).style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            obs.observe(el);
        });
        return () => obs.disconnect();
    }, [loading]);

    /* Cart toast */
    const showToast = () => {
        setToast(true);
        clearTimeout(toastRef.current);
        toastRef.current = setTimeout(() => setToast(false), 2500);
    };

    /* Smooth scroll */
    const scrollTo = (id: string) => {
        const el = document.getElementById(id);
        if (!el) return;
        const navH = navRef.current?.offsetHeight ?? 0;
        window.scrollTo({ top: el.offsetTop - navH, behavior: 'smooth' });
        setMobileOpen(false);
    };

    const NAV_LINKS = [
        { id: 'home',       label: 'หน้าแรก' },
        { id: 'about',      label: 'เกี่ยวกับเรา' },
        { id: 'menu',       label: 'เมนู' },
        { id: 'gallery',    label: 'แกลเลอรี' },
        { id: 'promotions', label: 'โปรโมชัน' },
        { id: 'reviews',    label: 'รีวิว' },
        { id: 'contact',    label: 'ติดต่อ' },
    ];

    const FEATURES = [
        { icon: '🌿', title: 'วิวธรรมชาติ',         desc: 'ทุ่งนา ต้นไม้ บรรยากาศเงียบสงบ' },
        { icon: '📸', title: 'มุมถ่ายรูปสวย',       desc: 'จุด Instagrammable ทั่วร้าน' },
        { icon: '📶', title: 'Free Wi-Fi ความเร็วสูง', desc: 'รองรับการทำงานและเรียน' },
        { icon: '🔌', title: 'ปลั๊กไฟทุกโต๊ะ',     desc: 'ไม่ต้องกังวลเรื่องแบตเตอรี่' },
        { icon: '🍽️', title: 'เมนูหลากหลาย',       desc: 'กาแฟ เครื่องดื่ม เบเกอรี และอาหาร' },
    ];

    if (loading) {
        return (
            <div className="fixed inset-0 bg-cafe-cream flex items-center justify-center z-50">
                <div className="text-center">
                    <div className="w-20 h-20 rounded-full bg-gradient-to-br from-cafe-green to-cafe-green-dark
                                    flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4
                                    animate-pulse-slow shadow-green">บ</div>
                    <p className="text-cafe-green-dark font-medium tracking-[0.12em] text-sm mb-6">Barjong Cafe</p>
                    <div className="w-48 h-0.5 bg-cafe-beige rounded-full overflow-hidden mx-auto">
                        <div className="h-full bg-gradient-to-r from-cafe-green to-cafe-green-light
                                        rounded-full animate-loader-progress" />
                    </div>
                </div>
            </div>
        );
    }

    return (
        <>
            <Head title="บรรจงคาเฟ่ | Barjong Cafe" />

            {/* ══════════ NAVBAR ══════════ */}
            <nav ref={navRef} id="navbar"
                className={`fixed top-0 left-0 right-0 z-50 transition-all duration-500
                    ${scrolled ? 'glass-white shadow-sm py-3' : 'py-5'}`}>
                <div className="max-w-7xl mx-auto px-8 flex items-center gap-6">
                    {/* Logo */}
                    <a href="#home" onClick={e => { e.preventDefault(); scrollTo('home'); }}
                        className={`flex items-center gap-2 font-bold text-lg whitespace-nowrap transition-colors duration-300
                            ${scrolled ? 'text-cafe-brown-dark' : 'text-white'}`}>
                        <span className="text-xl">☕</span> บรรจงคาเฟ่
                    </a>

                    {/* Desktop links */}
                    <ul className="hidden lg:flex items-center gap-1 ml-auto">
                        {NAV_LINKS.map(l => (
                            <li key={l.id}>
                                <button onClick={() => scrollTo(l.id)}
                                    className={`px-3 py-1.5 rounded-full text-sm transition-all duration-200
                                        ${activeSection === l.id
                                            ? 'text-cafe-green bg-cafe-green/10'
                                            : scrolled ? 'text-gray-500 hover:text-cafe-green hover:bg-cafe-green/10'
                                                       : 'text-white/85 hover:text-white hover:bg-white/10'}`}>
                                    {l.label}
                                </button>
                            </li>
                        ))}
                    </ul>

                    {/* CTA Button */}
                    <button id="navOrderBtn" onClick={() => scrollTo('menu')}
                        className="hidden lg:flex items-center gap-2 bg-cafe-green text-white px-5 py-2.5 rounded-full
                                   text-sm font-medium hover:bg-cafe-green-dark hover:shadow-green transition-all duration-300
                                   hover:-translate-y-0.5">
                        สั่งเลย
                    </button>

                    {/* Hamburger */}
                    <button id="hamburger" onClick={() => setMobileOpen(!mobileOpen)}
                        className="lg:hidden ml-auto p-2 flex flex-col gap-1.5" aria-label="toggle menu">
                        <span className={`block w-6 h-0.5 transition-all duration-300
                            ${scrolled ? 'bg-gray-800' : 'bg-white'}
                            ${mobileOpen ? 'translate-y-2 rotate-45' : ''}`} />
                        <span className={`block w-6 h-0.5 transition-all duration-300
                            ${scrolled ? 'bg-gray-800' : 'bg-white'}
                            ${mobileOpen ? 'opacity-0' : ''}`} />
                        <span className={`block w-6 h-0.5 transition-all duration-300
                            ${scrolled ? 'bg-gray-800' : 'bg-white'}
                            ${mobileOpen ? '-translate-y-2 -rotate-45' : ''}`} />
                    </button>
                </div>

                {/* Mobile Menu */}
                {mobileOpen && (
                    <div className="lg:hidden fixed inset-0 bg-cafe-cream/97 backdrop-blur-xl z-40 flex flex-col
                                    items-center justify-center gap-6">
                        {NAV_LINKS.map(l => (
                            <button key={l.id} onClick={() => scrollTo(l.id)}
                                className="text-2xl font-medium text-cafe-brown-dark hover:text-cafe-green transition-colors">
                                {l.label}
                            </button>
                        ))}
                    </div>
                )}
            </nav>

            {/* ══════════ HERO ══════════ */}
            <section id="home" className="relative w-full h-screen min-h-[650px] flex items-center justify-center overflow-hidden">
                {/* BG */}
                <div className="absolute inset-0">
                    <div className="w-full h-full bg-gradient-to-br from-cafe-green-dark via-cafe-green to-emerald-800
                                    animate-hero-pan" />
                    {/* Decorative circles */}
                    <div className="absolute top-1/4 right-1/4 w-80 h-80 rounded-full bg-white/5 blur-3xl" />
                    <div className="absolute bottom-1/3 left-1/3 w-96 h-96 rounded-full bg-cafe-green-light/10 blur-3xl" />
                </div>
                <div className="absolute inset-0 hero-overlay" />

                {/* Content */}
                <div className="relative z-10 text-center text-white px-6 animate-slide-up">
                    <div className="inline-block glass rounded-full px-5 py-2 text-xs font-light tracking-widest mb-6">
                        🌿 เปิดทุกวัน 07:00 – 20:00 น.
                    </div>
                    <h1 className="text-shadow mb-4">
                        <span className="block text-5xl sm:text-7xl font-bold leading-none">บรรจงคาเฟ่</span>
                        <span className="block text-base sm:text-xl font-light tracking-[0.3em] mt-2 opacity-85">
                            BARJONG CAFE
                        </span>
                    </h1>
                    <p className="text-base sm:text-lg font-light opacity-90 tracking-widest mb-10">
                        กาแฟดี · บรรยากาศธรรมชาติ · พื้นที่แห่งการพักผ่อน
                    </p>

                    {/* Buttons */}
                    <div className="flex gap-4 justify-center flex-wrap mb-14">
                        <button id="heroBtnMenu" onClick={() => scrollTo('menu')}
                            className="flex items-center gap-2 bg-cafe-green text-white px-8 py-3.5 rounded-full
                                       font-medium hover:bg-cafe-green-dark hover:shadow-green hover:-translate-y-0.5
                                       transition-all duration-300">
                            ☕ ดูเมนู
                        </button>
                        <button id="heroBtnOrder" onClick={() => scrollTo('contact')}
                            className="flex items-center gap-2 glass text-white px-8 py-3.5 rounded-full
                                       font-medium hover:bg-white/25 hover:-translate-y-0.5 transition-all duration-300 border-white/50 border">
                            🛍 สั่งอาหาร
                        </button>
                    </div>

                    {/* Stats */}
                    <div className="inline-flex items-center gap-6 glass rounded-full px-8 py-4">
                        <div className="text-center">
                            <div className="text-xl font-bold">500+</div>
                            <div className="text-xs opacity-75 tracking-wide">รีวิวดีเยี่ยม</div>
                        </div>
                        <div className="w-px h-9 bg-white/30" />
                        <div className="text-center">
                            <div className="text-xl font-bold">4.9</div>
                            <div className="text-xs opacity-75 tracking-wide">คะแนนเฉลี่ย</div>
                        </div>
                        <div className="w-px h-9 bg-white/30" />
                        <div className="text-center">
                            <div className="text-xl font-bold">50+</div>
                            <div className="text-xs opacity-75 tracking-wide">รายการเมนู</div>
                        </div>
                    </div>
                </div>

                {/* Scroll indicator */}
                <button onClick={() => scrollTo('about')} id="scrollIndicator"
                    className="absolute bottom-9 left-1/2 -translate-x-1/2 z-10 w-10 h-10 rounded-full border
                               border-white/40 flex items-center justify-center animate-bounce-sm">
                    <div className="w-1.5 h-1.5 bg-white rounded-full" />
                </button>
            </section>

            {/* ══════════ ABOUT ══════════ */}
            <section id="about" className="py-24 bg-white">
                <div className="max-w-7xl mx-auto px-8">
                    <div className="grid lg:grid-cols-2 gap-16 items-center">

                        {/* Images */}
                        <div data-reveal className="relative">
                            <div className="rounded-3xl overflow-hidden aspect-[4/5] shadow-cafe">
                                <div className="w-full h-full bg-gradient-to-br from-cafe-green-dark to-cafe-green
                                                flex items-center justify-center">
                                    <span className="text-9xl select-none">🏡</span>
                                </div>
                            </div>
                            {/* Badge card */}
                            <div className="absolute -bottom-8 -right-6 bg-white rounded-2xl shadow-cafe border-4 border-white
                                            overflow-hidden w-52">
                                <div className="h-28 bg-gradient-to-br from-emerald-700 to-emerald-400
                                                flex items-center justify-center">
                                    <span className="text-5xl">🌾</span>
                                </div>
                                <div className="flex items-center gap-2.5 p-3">
                                    <span className="text-2xl">🌿</span>
                                    <div>
                                        <p className="text-xs font-semibold text-cafe-brown-dark">วิวธรรมชาติ</p>
                                        <p className="text-[10px] text-gray-400">ทุ่งนา & ต้นไม้</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Content */}
                        <div data-reveal style={{ transitionDelay: '0.15s' }}>
                            <Tag>เกี่ยวกับเรา</Tag>
                            <h2 className="text-4xl font-bold text-cafe-brown-dark leading-tight mb-5">
                                พื้นที่สงบ<br />
                                <em className="not-italic text-cafe-green">ท่ามกลางธรรมชาติ</em>
                            </h2>
                            <p className="text-gray-500 leading-[1.9] mb-8 text-sm">
                                บรรจงคาเฟ่ คือพื้นที่พักผ่อนกลางธรรมชาติ ที่เราออกแบบมาเพื่อให้คุณได้หยุดพัก ชาร์จพลัง
                                และสัมผัสกับบรรยากาศอบอุ่น ท่ามกลางวิวทุ่งนาและต้นไม้สีเขียว กาแฟทุกแก้วชงด้วยใจ
                                พร้อมให้คุณรู้สึกเหมือนอยู่บ้าน
                            </p>
                            <div className="grid grid-cols-2 gap-4">
                                {FEATURES.map(f => (
                                    <div key={f.title}
                                        className="flex items-start gap-3 p-4 rounded-xl bg-cafe-cream
                                                   hover:bg-white hover:shadow-md hover:-translate-y-1 transition-all duration-400">
                                        <div className="w-10 h-10 rounded-xl bg-cafe-green/15 flex items-center
                                                        justify-center text-lg flex-shrink-0">{f.icon}</div>
                                        <div>
                                            <p className="text-xs font-semibold text-cafe-brown-dark mb-0.5">{f.title}</p>
                                            <p className="text-[11px] text-gray-400">{f.desc}</p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* ══════════ MENU ══════════ */}
            <section id="menu" className="py-24 bg-cafe-cream">
                <div className="max-w-7xl mx-auto px-8">
                    <div data-reveal className="text-center mb-14">
                        <Tag>เมนูของเรา</Tag>
                        <h2 className="text-4xl font-bold text-cafe-brown-dark mb-3">ดื่มด่ำกับทุกรสชาติ</h2>
                        <p className="text-gray-400 text-sm max-w-md mx-auto">คัดสรรวัตถุดิบคุณภาพ ชงด้วยความใส่ใจ เพื่อประสบการณ์ที่ดีที่สุด</p>
                    </div>

                    {/* Tabs */}
                    <div data-reveal className="flex justify-center gap-2.5 flex-wrap mb-12">
                        {([
                            { key: 'coffee',    label: '☕ Coffee' },
                            { key: 'noncoffee', label: '🧋 Non-Coffee' },
                            { key: 'bakery',    label: '🥐 Bakery' },
                            { key: 'food',      label: '🍽️ Food' },
                        ] as { key: TabKey; label: string }[]).map(t => (
                            <button key={t.key} id={`tab${t.key}`}
                                onClick={() => setActiveTab(t.key)}
                                className={`px-6 py-2.5 rounded-full text-sm font-medium border transition-all duration-300
                                    ${activeTab === t.key
                                        ? 'bg-cafe-green text-white border-cafe-green shadow-green'
                                        : 'bg-white text-gray-500 border-cafe-beige hover:border-cafe-green hover:text-cafe-green'}`}>
                                {t.label}
                            </button>
                        ))}
                    </div>

                    {/* Cards */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        {MENU[activeTab].map(item => (
                            <MenuCard key={item.id} item={item} onAdd={showToast} />
                        ))}
                    </div>
                </div>
            </section>

            {/* ══════════ GALLERY ══════════ */}
            <section id="gallery" className="py-24 bg-white">
                <div className="max-w-7xl mx-auto px-8">
                    <div data-reveal className="text-center mb-14">
                        <Tag>แกลเลอรี</Tag>
                        <h2 className="text-4xl font-bold text-cafe-brown-dark mb-3">บรรยากาศของเรา</h2>
                        <p className="text-gray-400 text-sm">ทุกมุมมองออกแบบมาเพื่อให้คุณรู้สึกผ่อนคลาย</p>
                    </div>

                    {/* Masonry-style grid */}
                    <div data-reveal className="grid grid-cols-3 gap-4" style={{ gridAutoRows: '200px' }}>
                        {GALLERY.map((g, i) => (
                            <div key={i}
                                className={`group relative rounded-2xl overflow-hidden cursor-pointer
                                            ${g.tall ? 'row-span-2' : ''}`}>
                                <div className={`w-full h-full bg-gradient-to-br ${g.bg} flex items-center
                                                 justify-center text-7xl group-hover:scale-110 transition-transform duration-700`}>
                                    {g.emoji}
                                </div>
                                <div className="absolute inset-0 masonry-overlay-fade opacity-0 group-hover:opacity-100
                                                transition-opacity duration-400 flex items-end p-5">
                                    <span className="text-white text-sm font-medium tracking-wide">{g.label}</span>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* ══════════ PROMOTIONS ══════════ */}
            <section id="promotions" className="py-24 bg-green-gradient">
                <div className="max-w-7xl mx-auto px-8">
                    <div data-reveal className="text-center mb-14">
                        <Tag light>โปรโมชัน</Tag>
                        <h2 className="text-4xl font-bold text-white mb-3">ข้อเสนอพิเศษ</h2>
                        <p className="text-white/70 text-sm">อัปเดตโปรโมชันล่าสุดจากบรรจงคาเฟ่</p>
                    </div>

                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        {/* Featured promo */}
                        <div data-reveal
                            className="lg:col-span-1 glass rounded-2xl p-8 text-white hover:-translate-y-1.5
                                       transition-all duration-400 border-white/35">
                            <p className="text-[11px] font-semibold tracking-[0.1em] uppercase opacity-80 mb-3">🔥 ดีลพิเศษ</p>
                            <h3 className="text-2xl font-bold mb-3">ซื้อ 2 แก้ว แถมฟรี 1</h3>
                            <p className="text-sm opacity-80 leading-relaxed mb-4">ทุกเมนูในหมวด Coffee และ Non-Coffee เฉพาะวันจันทร์–พุธ</p>
                            <p className="text-xs opacity-65 mb-6">📅 ถึง 31 ก.ค. 2026</p>
                            <button id="promoBtnDeal" onClick={() => scrollTo('menu')}
                                className="bg-white text-cafe-green-dark px-6 py-2.5 rounded-full text-sm font-medium
                                           hover:bg-cafe-cream hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                                ดูรายละเอียด
                            </button>
                        </div>
                        <div data-reveal style={{ transitionDelay: '0.1s' }}
                            className="glass rounded-2xl p-8 text-white hover:-translate-y-1.5 transition-all duration-400">
                            <p className="text-[11px] font-semibold tracking-[0.1em] uppercase opacity-80 mb-3">☀️ Morning Deal</p>
                            <h3 className="text-2xl font-bold mb-3">Morning Set ลด 20%</h3>
                            <p className="text-sm opacity-80 leading-relaxed mb-4">สั่ง Coffee + Bakery ก่อน 10:00 น. รับส่วนลด 20% ทันที</p>
                            <p className="text-xs opacity-65 mb-6">📅 ถึง 30 มิ.ย. 2026</p>
                            <button id="promoBtnMorning" onClick={() => scrollTo('menu')}
                                className="border border-white/60 text-white px-6 py-2.5 rounded-full text-sm font-medium
                                           hover:bg-white/15 hover:-translate-y-0.5 transition-all duration-300">
                                ดูรายละเอียด
                            </button>
                        </div>
                        <div data-reveal style={{ transitionDelay: '0.2s' }}
                            className="glass rounded-2xl p-8 text-white hover:-translate-y-1.5 transition-all duration-400">
                            <p className="text-[11px] font-semibold tracking-[0.1em] uppercase opacity-80 mb-3">📱 Member Exclusive</p>
                            <h3 className="text-2xl font-bold mb-3">สมาชิกใหม่รับฟรีเครื่องดื่ม</h3>
                            <p className="text-sm opacity-80 leading-relaxed mb-4">สมัครสมาชิกวันนี้ รับเครื่องดื่มฟรี 1 แก้วทันที ไม่มีเงื่อนไข</p>
                            <p className="text-xs opacity-65 mb-6">📅 ไม่มีวันหมดอายุ</p>
                            <button id="promoBtnMember" onClick={() => scrollTo('contact')}
                                className="border border-white/60 text-white px-6 py-2.5 rounded-full text-sm font-medium
                                           hover:bg-white/15 hover:-translate-y-0.5 transition-all duration-300">
                                ดูรายละเอียด
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            {/* ══════════ REVIEWS ══════════ */}
            <section id="reviews" className="py-24 bg-cafe-cream overflow-hidden">
                <div className="max-w-7xl mx-auto px-8">
                    <div data-reveal className="text-center mb-12">
                        <Tag>รีวิวลูกค้า</Tag>
                        <h2 className="text-4xl font-bold text-cafe-brown-dark mb-4">เสียงจากหัวใจลูกค้า</h2>
                        <div className="flex items-center justify-center gap-3">
                            <span className="text-4xl font-bold text-cafe-green-dark">4.9</span>
                            <span className="text-yellow-400 text-xl">★★★★★</span>
                            <span className="text-sm text-gray-400">จาก 500+ รีวิว</span>
                        </div>
                    </div>

                    {/* Infinite scroll track */}
                    <div className="relative overflow-hidden">
                        <div className="flex gap-6 animate-scroll-x w-max hover:[animation-play-state:paused]">
                            {[...REVIEWS, ...REVIEWS].map((r, i) => (
                                <div key={i}
                                    className="flex-none w-80 bg-white rounded-2xl p-7 border border-cafe-beige
                                               shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-400">
                                    <div className="flex items-center gap-3 mb-4">
                                        <div className="w-11 h-11 rounded-full flex items-center justify-center
                                                        text-white font-bold text-base flex-shrink-0"
                                            style={{ background: `linear-gradient(135deg, ${r.from}, ${r.to})` }}>
                                            {r.initial}
                                        </div>
                                        <div className="flex-1 min-w-0">
                                            <p className="text-sm font-semibold text-cafe-brown-dark truncate">{r.name}</p>
                                            <p className="text-xs text-gray-400">{r.src}</p>
                                        </div>
                                        <span className="text-yellow-400 text-sm flex-shrink-0">⭐⭐⭐⭐⭐</span>
                                    </div>
                                    <p className="text-sm text-gray-500 leading-relaxed">"{r.text}"</p>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </section>

            {/* ══════════ CONTACT ══════════ */}
            <section id="contact" className="py-24 bg-white">
                <div className="max-w-7xl mx-auto px-8">
                    <div data-reveal className="text-center mb-14">
                        <Tag>ติดต่อเรา</Tag>
                        <h2 className="text-4xl font-bold text-cafe-brown-dark mb-3">มาเยี่ยมเราได้เลย</h2>
                        <p className="text-gray-400 text-sm">ยินดีต้อนรับทุกวัน ไม่มีวันหยุด</p>
                    </div>

                    <div className="grid lg:grid-cols-2 gap-14 items-start">
                        {/* Info */}
                        <div data-reveal>
                            <div className="bg-cafe-cream rounded-2xl p-8 mb-6 border border-cafe-beige">
                                {[
                                    { icon: '📍', title: 'ที่อยู่',          text: '123 ถนนธรรมชาติ ตำบลสวนงาม\nอำเภอเมือง จังหวัดเชียงใหม่ 50000' },
                                    { icon: '🕐', title: 'เวลาเปิด-ปิด',    text: 'จันทร์ – ศุกร์: 07:00 – 20:00 น.\nเสาร์ – อาทิตย์: 07:00 – 21:00 น.' },
                                    { icon: '📞', title: 'โทรศัพท์',        text: '081-234-5678' },
                                ].map((c, i) => (
                                    <div key={i} className={`flex gap-4 py-4 ${i < 2 ? 'border-b border-cafe-beige' : ''}`}>
                                        <div className="w-11 h-11 rounded-xl bg-cafe-green/12 flex items-center
                                                        justify-center text-lg flex-shrink-0">{c.icon}</div>
                                        <div>
                                            <p className="text-xs font-semibold text-cafe-brown-dark mb-1">{c.title}</p>
                                            <p className="text-sm text-gray-500 whitespace-pre-line">{c.text}</p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                            {/* Social */}
                            <div className="flex flex-col gap-3">
                                <a id="socialFacebook" href="#"
                                    className="flex items-center gap-4 bg-blue-600 text-white px-5 py-3.5 rounded-xl
                                               text-sm font-medium hover:translate-x-1.5 hover:shadow-md transition-all duration-300">
                                    <span className="text-lg">📘</span> Barjong Cafe (Facebook)
                                </a>
                                <a id="socialLine" href="#"
                                    className="flex items-center gap-4 bg-green-500 text-white px-5 py-3.5 rounded-xl
                                               text-sm font-medium hover:translate-x-1.5 hover:shadow-md transition-all duration-300">
                                    <span className="text-lg">💬</span> @barjongcafe (LINE)
                                </a>
                                <a id="socialInstagram" href="#"
                                    className="flex items-center gap-4 text-white px-5 py-3.5 rounded-xl text-sm font-medium
                                               hover:translate-x-1.5 hover:shadow-md transition-all duration-300"
                                    style={{ background: 'linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888)' }}>
                                    <span className="text-lg">📸</span> @barjong.cafe (Instagram)
                                </a>
                            </div>
                        </div>

                        {/* Map placeholder */}
                        <div data-reveal style={{ transitionDelay: '0.15s' }}>
                            <div className="rounded-2xl overflow-hidden shadow-cafe h-80 bg-gradient-to-br
                                            from-cafe-green-dark to-cafe-green flex items-center justify-center">
                                <div className="text-center text-white">
                                    <div className="text-6xl mb-3">🗺️</div>
                                    <p className="font-semibold text-lg">Google Maps</p>
                                    <p className="text-sm opacity-75 mt-1">คลิกเพื่อดูเส้นทาง</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* ══════════ FOOTER ══════════ */}
            <footer className="bg-cafe-brown-dark text-white/70 pt-16 pb-0">
                <div className="max-w-7xl mx-auto px-8">
                    <div className="grid grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-white/10">
                        {/* Brand */}
                        <div className="col-span-2 lg:col-span-1">
                            <div className="flex items-center gap-2 text-white text-xl font-bold mb-3">
                                ☕ บรรจงคาเฟ่
                            </div>
                            <p className="text-sm leading-relaxed mb-5">
                                กาแฟดี บรรยากาศธรรมชาติ<br />พื้นที่แห่งการพักผ่อน
                            </p>
                            <div className="flex gap-3">
                                {['📘','📸','💬','🎵'].map((ic, i) => (
                                    <a key={i} href="#"
                                        className="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center
                                                   hover:bg-cafe-green hover:text-white transition-all duration-300
                                                   hover:-translate-y-0.5 text-sm">
                                        {ic}
                                    </a>
                                ))}
                            </div>
                        </div>

                        {/* Quick links */}
                        <div>
                            <h4 className="text-white font-semibold text-sm mb-4 tracking-wide">เมนูลัด</h4>
                            <ul className="space-y-2.5">
                                {NAV_LINKS.map(l => (
                                    <li key={l.id}>
                                        <button onClick={() => scrollTo(l.id)}
                                            className="text-sm hover:text-cafe-green-light hover:pl-1 transition-all duration-200">
                                            {l.label}
                                        </button>
                                    </li>
                                ))}
                            </ul>
                        </div>

                        {/* Services */}
                        <div>
                            <h4 className="text-white font-semibold text-sm mb-4 tracking-wide">บริการ</h4>
                            <ul className="space-y-2.5 text-sm">
                                {['Dine-in','Take Away','Delivery','จองโต๊ะ','Private Event'].map(s => (
                                    <li key={s}><a href="#" className="hover:text-cafe-green-light transition-colors">{s}</a></li>
                                ))}
                            </ul>
                        </div>

                        {/* Hours */}
                        <div>
                            <h4 className="text-white font-semibold text-sm mb-4 tracking-wide">เวลาเปิดทำการ</h4>
                            <div className="space-y-2 text-sm">
                                <div className="flex justify-between py-2 border-b border-white/10">
                                    <span>จ–ศ</span><span>07:00 – 20:00</span>
                                </div>
                                <div className="flex justify-between py-2 border-b border-white/10">
                                    <span>ส–อ</span><span>07:00 – 21:00</span>
                                </div>
                                <div className="py-2 text-green-400 font-medium">🟢 เปิดอยู่ตอนนี้</div>
                            </div>
                        </div>
                    </div>

                    <div className="flex flex-col sm:flex-row justify-between items-center gap-2 py-6 text-xs opacity-50">
                        <p>© 2026 บรรจงคาเฟ่ (Barjong Cafe). All Rights Reserved.</p>
                        <p>Designed with ❤️ for coffee lovers</p>
                    </div>
                </div>
            </footer>

            {/* ══════════ TOAST ══════════ */}
            <div className={`fixed bottom-8 left-1/2 -translate-x-1/2 z-50 flex items-center gap-3
                             bg-cafe-green-dark text-white px-7 py-3.5 rounded-full shadow-cafe text-sm font-medium
                             transition-all duration-400
                             ${toast ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4 pointer-events-none'}`}>
                ✅ เพิ่มลงในตะกร้าแล้ว!
            </div>

            {/* ══════════ BACK TO TOP ══════════ */}
            <button id="backToTop" onClick={() => window.scrollTo({ top: 0, behavior: 'smooth' })}
                className={`fixed bottom-8 right-8 z-50 w-12 h-12 rounded-full bg-cafe-green text-white
                             flex items-center justify-center shadow-green
                             hover:bg-cafe-green-dark hover:-translate-y-1
                             transition-all duration-400
                             ${showTop ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4 pointer-events-none'}`}
                aria-label="Back to top">
                <Icon path="M4.5 15.75l7.5-7.5 7.5 7.5" className="w-5 h-5" />
            </button>
        </>
    );
}
