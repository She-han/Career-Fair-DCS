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
                    ? 'bg-white/90 dark:bg-gray-900/90 backdrop-blur-lg border-b border-gray-200 dark:border-gray-800 shadow-lg' 
                    : 'bg-transparent border-b border-transparent'
            }`}>
                <div className="container px-4 mx-auto sm:px-6 lg:px-8">
                    <div className="flex items-center justify-between h-16">
                        {/* Logo */}
                        <div className="flex items-center">
                            <Link href="/" className="flex items-center space-x-3 group">
                                <div className="flex items-center justify-center w-10 h-10 transition-transform duration-200 transform rounded-lg bg-gradient-to-br from-blue-500 via-purple-500 to-cyan-500 group-hover:scale-110">
                                    <span className="text-xl font-bold text-white">CF</span>
                                </div>
                                <span className={`text-xl font-bold transition-all duration-300 ${
                                    isScrolled
                                        ? 'text-transparent bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 bg-clip-text'
                                        : 'text-white drop-shadow-lg'
                                }`}>
                                    Career Fair DCS
                                </span>
                            </Link>
                        </div>

                        {/* Desktop Navigation */}
                        <div className="items-center hidden space-x-8 md:flex">
                            <Link 
                                href="/" 
                                className={`font-medium transition-colors ${
                                    isScrolled
                                        ? 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400'
                                        : 'text-white hover:text-blue-200'
                                }`}
                            >
                                Home
                            </Link>
                            
                            {!auth.user ? (
                                <>
                                    <a 
                                        href="/login" 
                                        className={`font-medium transition-colors ${
                                            isScrolled
                                                ? 'text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400'
                                                : 'text-white hover:text-purple-200'
                                        }`}
                                    >
                                        Login
                                    </a>
                                    <a 
                                        href="/register" 
                                        className="px-4 py-2 font-medium text-white transition-all duration-200 rounded-lg bg-gradient-to-r from-blue-600 to-purple-600 hover:shadow-lg hover:scale-105"
                                    >
                                        Sign Up
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
                            <Link 
                                href="/" 
                                className={`block px-4 py-2 transition-colors rounded-lg ${
                                    isScrolled
                                        ? 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'
                                        : 'text-white hover:bg-white/10'
                                }`}
                            >
                                Home
                            </Link>
                            {!auth.user ? (
                                <>
                                    <a 
                                        href="/login" 
                                        className={`block px-4 py-2 transition-colors rounded-lg ${
                                            isScrolled
                                                ? 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'
                                                : 'text-white hover:bg-white/10'
                                        }`}
                                    >
                                        Login
                                    </a>
                                    <a 
                                        href="/register" 
                                        className="block px-4 py-2 font-medium text-center text-white rounded-lg bg-gradient-to-r from-blue-600 to-purple-600"
                                    >
                                        Sign Up
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
            <footer className="relative transition-colors duration-200 overflow-hidden bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50 dark:from-gray-900 dark:via-blue-950 dark:to-purple-950 border-t border-gray-200 dark:border-gray-800">
                {/* Subtle background gradient orbs */}
                <div className="absolute inset-0 overflow-hidden pointer-events-none">
                    <div className="absolute rounded-full -top-20 -left-20 w-64 h-64 bg-gradient-to-br from-blue-200 to-purple-200 dark:from-blue-900/20 dark:to-purple-900/20 mix-blend-multiply filter blur-3xl opacity-30"></div>
                    <div className="absolute rounded-full -bottom-20 -right-20 w-64 h-64 bg-gradient-to-br from-purple-200 to-cyan-200 dark:from-purple-900/20 dark:to-cyan-900/20 mix-blend-multiply filter blur-3xl opacity-30"></div>
                </div>

                <div className="container relative z-10 px-4 py-12 mx-auto sm:px-6 lg:px-8">
                    <div className="grid grid-cols-1 gap-8 mb-8 md:grid-cols-3">
                        <div className="space-y-4">
                            <div className="flex items-center space-x-3">
                                <div className="flex items-center justify-center w-10 h-10 rounded-lg shadow-lg bg-gradient-to-br from-blue-500 via-purple-500 to-cyan-500">
                                    <span className="text-xl font-bold text-white">CF</span>
                                </div>
                                <h3 className="text-xl font-bold text-transparent bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 bg-clip-text">Career Fair DCS</h3>
                            </div>
                            <p className="text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                                Connecting talented students with leading companies for a brighter future in technology.
                            </p>
                            <div className="flex space-x-4">
                                <a href="#" className="text-gray-500 transition-colors hover:text-blue-600 dark:hover:text-blue-400">
                                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                                <a href="#" className="text-gray-500 transition-colors hover:text-purple-600 dark:hover:text-purple-400">
                                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                </a>
                                <a href="#" className="text-gray-500 transition-colors hover:text-cyan-600 dark:hover:text-cyan-400">
                                    <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>
                            </div>
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
                                <li>
                                    <Link href="/register" className="flex items-center text-gray-600 transition-colors dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 group">
                                        <span className="mr-2 transition-transform group-hover:translate-x-1">→</span>
                                        Register
                                    </Link>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h3 className="mb-4 text-lg font-bold text-gray-800 dark:text-gray-200">Contact Us</h3>
                            <div className="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                                <p className="flex items-start">
                                    <svg className="flex-shrink-0 w-5 h-5 mt-0.5 mr-2 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span>Department of Computer Science<br />University of Ruhuna</span>
                                </p>
                                <p className="flex items-center">
                                    <svg className="flex-shrink-0 w-5 h-5 mr-2 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <a href="mailto:contact@careerfair.com" className="hover:text-purple-600 dark:hover:text-purple-400">contact@careerfair.com</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div className="pt-8 mt-8 text-center border-t border-gray-200 dark:border-gray-700">
                        <p className="text-sm text-gray-600 dark:text-gray-400">
                            &copy; {new Date().getFullYear()} Career Fair DCS. All rights reserved. | Made with <span className="text-red-500">♥</span> by DCS Students
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    );
}
