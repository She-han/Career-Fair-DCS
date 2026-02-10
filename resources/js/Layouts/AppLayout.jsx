import { Link, usePage } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import { Bars3Icon, XMarkIcon, MoonIcon, SunIcon } from '@heroicons/react/24/outline';

export default function AppLayout({ children }) {
    const { auth } = usePage().props;
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
    const [isDark, setIsDark] = useState(false);

    useEffect(() => {
        setIsDark(localStorage.getItem('theme') === 'dark');
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
        <div className="min-h-screen bg-white dark:bg-gray-900 transition-colors duration-200">
            {/* Navigation */}
            <nav className="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-b border-gray-200 dark:border-gray-800 transition-colors duration-200">
                <div className="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center h-16">
                        {/* Logo */}
                        <div className="flex items-center">
                            <Link href="/" className="flex items-center space-x-3 group">
                                <div className="w-10 h-10 bg-gradient-to-br from-blue-500 via-purple-500 to-cyan-500 rounded-lg flex items-center justify-center transform group-hover:scale-110 transition-transform duration-200">
                                    <span className="text-white font-bold text-xl">CF</span>
                                </div>
                                <span className="text-xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 bg-clip-text text-transparent">
                                    Career Fair DCS
                                </span>
                            </Link>
                        </div>

                        {/* Desktop Navigation */}
                        <div className="hidden md:flex items-center space-x-8">
                            <Link 
                                href="/" 
                                className="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors"
                            >
                                Home
                            </Link>
                            
                            {!auth.user ? (
                                <>
                                    <Link 
                                        href="/login" 
                                        className="text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 font-medium transition-colors"
                                    >
                                        Login
                                    </Link>
                                    <Link 
                                        href="/register" 
                                        className="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-medium hover:shadow-lg hover:scale-105 transition-all duration-200"
                                    >
                                        Sign Up
                                    </Link>
                                </>
                            ) : (
                                <>
                                    <Link 
                                        href={auth.user.role === 'admin' ? '/admin/dashboard' : 
                                              auth.user.role === 'student' ? '/student/dashboard' : 
                                              '/company/dashboard'}
                                        className="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors"
                                    >
                                        Dashboard
                                    </Link>
                                    <div className="flex items-center space-x-2">
                                        <span className="text-gray-700 dark:text-gray-300 font-medium">{auth.user.name}</span>
                                        <span className="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300">
                                            {auth.user.role.replace('_', ' ').toUpperCase()}
                                        </span>
                                    </div>
                                    <Link 
                                        href="/logout" 
                                        method="post" 
                                        as="button"
                                        className="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 font-medium transition-colors"
                                    >
                                        Logout
                                    </Link>
                                </>
                            )}

                            {/* Theme Toggle */}
                            <button 
                                onClick={toggleTheme} 
                                className="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200"
                                title="Toggle theme"
                            >
                                {isDark ? (
                                    <SunIcon className="w-5 h-5 text-yellow-400" />
                                ) : (
                                    <MoonIcon className="w-5 h-5 text-gray-700" />
                                )}
                            </button>
                        </div>

                        {/* Mobile menu button */}
                        <div className="md:hidden flex items-center space-x-2">
                            <button 
                                onClick={toggleTheme} 
                                className="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
                            >
                                {isDark ? (
                                    <SunIcon className="w-5 h-5 text-yellow-400" />
                                ) : (
                                    <MoonIcon className="w-5 h-5 text-gray-700" />
                                )}
                            </button>
                            <button 
                                onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                                className="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
                            >
                                {mobileMenuOpen ? (
                                    <XMarkIcon className="w-6 h-6" />
                                ) : (
                                    <Bars3Icon className="w-6 h-6" />
                                )}
                            </button>
                        </div>
                    </div>

                    {/* Mobile Menu */}
                    {mobileMenuOpen && (
                        <div className="md:hidden py-4 space-y-3 border-t border-gray-200 dark:border-gray-800">
                            <Link 
                                href="/" 
                                className="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
                            >
                                Home
                            </Link>
                            {!auth.user ? (
                                <>
                                    <Link 
                                        href="/login" 
                                        className="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
                                    >
                                        Login
                                    </Link>
                                    <Link 
                                        href="/register" 
                                        className="block px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-medium text-center"
                                    >
                                        Sign Up
                                    </Link>
                                </>
                            ) : (
                                <>
                                    <Link 
                                        href={auth.user.role === 'admin' ? '/admin/dashboard' : 
                                              auth.user.role === 'student' ? '/student/dashboard' : 
                                              '/company/dashboard'}
                                        className="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
                                    >
                                        Dashboard
                                    </Link>
                                    <div className="px-4 py-2">
                                        <p className="text-sm font-medium text-gray-700 dark:text-gray-300">{auth.user.name}</p>
                                        <p className="text-xs text-gray-500 dark:text-gray-400">{auth.user.role.replace('_', ' ')}</p>
                                    </div>
                                    <Link 
                                        href="/logout" 
                                        method="post" 
                                        as="button"
                                        className="w-full text-left px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
                                    >
                                        Logout
                                    </Link>
                                </>
                            )}
                        </div>
                    )}
                </div>
            </nav>

            {/* Main Content */}
            <main className="pt-16 min-h-screen">
                {children}
            </main>

            {/* Footer */}
            <footer className="bg-gray-100 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 transition-colors duration-200">
                <div className="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <h3 className="text-lg font-bold mb-4 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Career Fair DCS</h3>
                            <p className="text-gray-600 dark:text-gray-400 text-sm">
                                Connecting talented students with leading companies for a brighter future.
                            </p>
                        </div>
                        <div>
                            <h3 className="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Quick Links</h3>
                            <ul className="space-y-2 text-sm">
                                <li><Link href="/" className="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">Home</Link></li>
                                <li><Link href="/login" className="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">Login</Link></li>
                                <li><Link href="/register" className="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">Register</Link></li>
                            </ul>
                        </div>
                        <div>
                            <h3 className="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Contact</h3>
                            <p className="text-gray-600 dark:text-gray-400 text-sm">
                                Department of Computer Science<br />
                                University of Ruhuna<br />
                                Email: contact@careerfair.com
                            </p>
                        </div>
                    </div>
                    <div className="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700 text-center">
                        <p className="text-gray-600 dark:text-gray-400 text-sm">
                            &copy; {new Date().getFullYear()} Career Fair DCS. All rights reserved.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    );
}
