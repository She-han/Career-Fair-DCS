import { Link, usePage } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import { Bars3Icon, XMarkIcon, MoonIcon, SunIcon } from '@heroicons/react/24/outline';

export default function AppLayout({ children }) {
    const { auth } = usePage().props;
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
    const [isScrolled, setIsScrolled] = useState(false);
    // Initialize from DOM to avoid hydration mismatch
    const [isDark, setIsDark] = useState(() => {
        if (typeof window !== 'undefined') {
            return document.documentElement.classList.contains('dark');
        }
        return false;
    });

    useEffect(() => {
        // Sync state with actual DOM class on mount
        const darkModeEnabled = document.documentElement.classList.contains('dark');
        setIsDark(darkModeEnabled);

        // Handle scroll for navbar background
        const handleScroll = () => {
            setIsScrolled(window.scrollY > 50);
        };

        window.addEventListener('scroll', handleScroll);
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    const toggleTheme = () => {
        const newTheme = !isDark;
        setIsDark(newTheme);
        if (newTheme) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    };

    return (
        <div className="min-h-screen transition-colors duration-200 bg-white dark:bg-gray-900">
            {/* Navigation */}
            <nav className={`fixed top-0 left-0 right-0 z-50 transition-all duration-300 ${
                isScrolled 
                    ? 'bg-white dark:bg-gray-900/90 backdrop-blur-lg border-b border-gray-200 dark:border-gray-800 shadow-lg' 
                    : 'bg-transparent border-b border-transparent'
            }`}>
                <div className="container px-4 mx-auto sm:px-6 lg:px-8">
                    <div className="flex items-center justify-between h-16">
                        {/* Logo */}
                        <div className="flex items-center">
                            <Link href="/" className="flex items-center space-x-3 group">
                            
                                <span className={`text-xl md:text-2xl font-medium transition-all duration-300 ${
                                    isScrolled
                                        ? 'text-transparent bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 bg-clip-text'
                                        : 'text-white drop-shadow-lg'
                                }`}>
                                    Career Fair DCS
                                </span>
                            </Link>
                        </div>

                        {/* Desktop Navigation */}
                        <div className="items-center hidden space-x-4 md:flex">
                        
                            {/* Theme Toggle */}
                            <button 
                                onClick={toggleTheme} 
                                className={`p-2 transition-all duration-200 rounded-lg ${
                                    isScrolled
                                        ? 'bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700'
                                        : 'bg-white/20 backdrop-blur-sm hover:bg-white/30'
                                }`}
                                title="Toggle theme"
                            >
                                {isDark ? (
                                    <SunIcon className="w-5 h-5 text-yellow-400" />
                                ) : (
                                    <MoonIcon className={`w-5 h-5 ${isScrolled ? 'text-gray-700' : 'text-white'}`} />
                                )}
                            </button>

                            {!auth.user ? (
                                <>
                                    
                                    <a 
                                        href="/login" 
                                        className="px-4 py-2 font-medium text-gray-400 transition-all duration-200 bg-transparent border-2 border-purple-600 rounded-lg hover:text-white dark:text-white hover:bg-purple-600 hover:shadow-lg "
                                    >
                                        Admin Login
                                    </a>
                                </>
                            ) : (
                                <>
                                    <a 
                                        href={auth.user.role === 'admin' ? '/admin/dashboard' : 
                                              auth.user.role === 'student' ? '/student/dashboard' : 
                                              '/company/dashboard'}
                                        className={`font-medium transition-colors ${
                                            isScrolled
                                                ? 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400'
                                                : 'text-white hover:text-blue-200'
                                        }`}
                                    >
                                        Dashboard
                                    </a>
                                    <div className="flex items-center space-x-2">
                                        <span className={`font-medium transition-colors ${
                                            isScrolled ? 'text-gray-700 dark:text-gray-300' : 'text-white'
                                        }`}>{auth.user.name}</span>
                                        <span className="px-2 py-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                            {auth.user.role.replace('_', ' ').toUpperCase()}
                                        </span>
                                    </div>
                                    <form action="/logout" method="POST" className="inline">
                                        <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content} />
                                        <button 
                                            type="submit"
                                            className={`font-medium transition-colors ${
                                                isScrolled
                                                    ? 'text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400'
                                                    : 'text-white hover:text-red-200'
                                            }`}
                                        >
                                            Logout
                                        </button>
                                    </form>
                                </>
                            )}

                            
                        </div>

                        {/* Mobile menu button */}
                        <div className="flex items-center space-x-2 md:hidden">
                            <button 
                                onClick={toggleTheme} 
                                className={`p-2 transition-all duration-200 rounded-lg ${
                                    isScrolled
                                        ? 'bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700'
                                        : 'bg-white/20 backdrop-blur-sm hover:bg-white/30'
                                }`}
                            >
                                {isDark ? (
                                    <SunIcon className="w-5 h-5 text-yellow-400" />
                                ) : (
                                    <MoonIcon className={`w-5 h-5 ${isScrolled ? 'text-gray-700' : 'text-white'}`} />
                                )}
                            </button>
                            <button 
                                onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                                className={`p-2 transition-all duration-200 rounded-lg ${
                                    isScrolled
                                        ? 'bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700'
                                        : 'bg-white/20 backdrop-blur-sm hover:bg-white/30'
                                }`}
                            >
                                {mobileMenuOpen ? (
                                    <XMarkIcon className={`w-6 h-6 ${isScrolled ? 'text-gray-700 dark:text-gray-300' : 'text-white'}`} />
                                ) : (
                                    <Bars3Icon className={`w-6 h-6 ${isScrolled ? 'text-gray-700 dark:text-gray-300' : 'text-white'}`} />
                                )}
                            </button>
                        </div>
                    </div>

                    {/* Mobile Menu */}
                    {mobileMenuOpen && (
                        <div className={`py-4 space-y-3 border-t md:hidden transition-colors ${
                            isScrolled
                                ? 'border-gray-200 dark:border-gray-800 bg-white/95 dark:bg-gray-900/95'
                                : 'border-white/20 bg-white/10 backdrop-blur-lg'
                        }`}>
                      
                            {!auth.user ? (
                                <>
                                    
                                    <a 
                                        href="/login" 
                                        className="block px-4 py-2 font-medium text-center text-gray-400 bg-transparent border-2 border-purple-600 rounded-lg dark:text-white hover:bg-purple-600 hover:shadow-lg"
                                    >
                                        Admin Login
                                    </a>
                                </>
                            ) : (
                                <>
                                    <a 
                                        href={auth.user.role === 'admin' ? '/admin/dashboard' : 
                                              auth.user.role === 'student' ? '/student/dashboard' : 
                                              '/company/dashboard'}
                                        className={`block px-4 py-2 transition-colors rounded-lg ${
                                            isScrolled
                                                ? 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'
                                                : 'text-white hover:bg-white/10'
                                        }`}
                                    >
                                        Dashboard
                                    </a>
                                    <div className="px-4 py-2">
                                        <p className={`text-sm font-medium ${
                                            isScrolled ? 'text-gray-700 dark:text-gray-300' : 'text-white'
                                        }`}>{auth.user.name}</p>
                                        <p className={`text-xs ${
                                            isScrolled ? 'text-gray-500 dark:text-gray-400' : 'text-white/70'
                                        }`}>{auth.user.role.replace('_', ' ')}</p>
                                    </div>
                                    <form action="/logout" method="POST" className="px-4">
                                        <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content} />
                                        <button 
                                            type="submit"
                                            className={`w-full text-left py-2 transition-colors rounded-lg ${
                                                isScrolled
                                                    ? 'text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-800'
                                                    : 'text-white hover:bg-white/10'
                                            }`}
                                        >
                                            Logout
                                        </button>
                                    </form>
                                </>
                            )}
                        </div>
                    )}
                </div>
            </nav>

            {/* Main Content */}
            <main className="min-h-screen">
                {children}
            </main>

            {/* Footer */}
            <footer className="relative overflow-hidden transition-colors duration-200 border-t border-gray-300 bg-gradient-to-b from-gray-50 to-purple-50 dark:from-gray-900 dark:to-purple-950 dark:border-gray-800">


                <div className="container relative z-10 px-4 py-12 mx-auto sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 gap-8 mb-8 md:grid-cols-3">
                        <div className="space-y-4">
                            <div className="flex items-center space-x-3">
                               
                                <h3 className="text-xl font-medium text-transparent md:text-2xl bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 bg-clip-text">Career Fair DCS</h3>
                            </div>
                            <p className="text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                                Connecting talented students with leading companies for a brighter future in technology.
                            </p>
                           
                        </div>
                        <div>
                            <h3 className="mb-4 text-lg font-bold text-gray-800 dark:text-gray-200">Quick Links</h3>
                            <ul className="space-y-3 text-sm">
                                <li>
                                    <Link href="/" className="flex items-center text-gray-600 transition-colors dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 group">
                                        <span className="mr-2 transition-transform group-hover:translate-x-1">→</span>
                                        Home
                                    </Link>
                                </li>
                                <li>
                                    <Link href="/login" className="flex items-center text-gray-600 transition-colors dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 group">
                                        <span className="mr-2 transition-transform group-hover:translate-x-1">→</span>
                                        Login
                                    </Link>
                                </li>
                           
                            </ul>
                        </div>
                        <div>
                            <h3 className="mb-4 text-lg font-bold text-gray-800 dark:text-gray-200">Contact Us</h3>
                            <div className="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                                <p className="flex items-start">
                                    <svg className="flex-shrink-0 w-5 h-5 mt-0.5 mr-2 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>Department of Computer Science<br />University of Ruhuna</span>
                                </p>
                                <p className="flex items-center">
                                    <svg className="flex-shrink-0 w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <a href="mailto:contact@careerfair.com" className="hover:text-purple-600 dark:hover:text-purple-400">aruna@dcs.ruh.ac.lk</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div className="pt-8 mt-8 text-center border-t border-gray-200 dark:border-gray-700">
                        <p className="text-sm text-gray-600 dark:text-gray-400">
                            &copy; {new Date().getFullYear()} Career Fair DCS | University of Ruhuna
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    );
}
