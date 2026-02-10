import { Link, usePage } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { UserPlusIcon, BuildingOfficeIcon, ChevronDownIcon } from '@heroicons/react/24/outline';
import { useEffect, useRef } from 'react';

export default function HeroSection() {
    const { auth } = usePage().props;
    const backgroundRef = useRef(null);

    useEffect(() => {
        const handleScroll = () => {
            if (backgroundRef.current) {
                const scrolled = window.pageYOffset;
                backgroundRef.current.style.transform = `translateY(${scrolled * 0.5}px)`;
            }
        };

        window.addEventListener('scroll', handleScroll);
        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    // Generate floating particles positions
    const particles = Array.from({ length: 20 }, (_, i) => ({
        id: i,
        left: `${Math.random() * 100}%`,
        top: `${Math.random() * 100}%`,
        delay: Math.random() * 5,
        duration: 3 + Math.random() * 4,
    }));

    return (
        <section className="relative overflow-hidden min-h-screen flex items-center bg-gradient-to-br from-blue-50 via-purple-50 to-cyan-50 dark:from-gray-900 dark:via-purple-950 dark:to-blue-950 transition-colors duration-500">
            {/* Animated Background Gradient Orbs with Parallax */}
            <div ref={backgroundRef} className="absolute inset-0 overflow-hidden">
                <motion.div
                    animate={{
                        scale: [1, 1.2, 1],
                        rotate: [0, 90, 0],
                    }}
                    transition={{
                        duration: 20,
                        repeat: Infinity,
                        ease: "easeInOut",
                    }}
                    className="absolute -top-40 -left-40 w-96 h-96 bg-gradient-to-br from-blue-400 via-purple-500 to-cyan-400 rounded-full mix-blend-multiply filter blur-3xl opacity-40 dark:opacity-20"
                />
                <motion.div
                    animate={{
                        scale: [1, 1.3, 1],
                        rotate: [0, -90, 0],
                    }}
                    transition={{
                        duration: 25,
                        repeat: Infinity,
                        ease: "easeInOut",
                        delay: 2,
                    }}
                    className="absolute -bottom-40 -right-40 w-96 h-96 bg-gradient-to-br from-purple-400 via-cyan-500 to-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-40 dark:opacity-20"
                />
                <motion.div
                    animate={{
                        scale: [1, 1.1, 1],
                        x: [-20, 20, -20],
                        y: [-20, 20, -20],
                    }}
                    transition={{
                        duration: 30,
                        repeat: Infinity,
                        ease: "easeInOut",
                        delay: 4,
                    }}
                    className="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-br from-cyan-400 via-blue-500 to-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-40 dark:opacity-20"
                />
            </div>

            {/* Floating Particles */}
            <div className="absolute inset-0 overflow-hidden pointer-events-none">
                {particles.map((particle) => (
                    <motion.div
                        key={particle.id}
                        animate={{
                            y: [-20, 20, -20],
                            opacity: [0.2, 0.5, 0.2],
                        }}
                        transition={{
                            duration: particle.duration,
                            repeat: Infinity,
                            delay: particle.delay,
                            ease: "easeInOut",
                        }}
                        className="absolute w-2 h-2 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full"
                        style={{ left: particle.left, top: particle.top }}
                    />
                ))}
            </div>

            {/* Grid Pattern Overlay */}
            <div 
                className="absolute inset-0 opacity-5" 
                style={{ 
                    backgroundImage: 'radial-gradient(circle, rgba(99, 102, 241, 0.4) 1px, transparent 1px)', 
                    backgroundSize: '30px 30px' 
                }}
            />

            <div className="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20">
                <div className="max-w-5xl mx-auto text-center">
                    {/* Main Heading */}
                    <motion.div
                        initial={{ opacity: 0, y: 50 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ duration: 0.8 }}
                        className="hero-title"
                    >
                        <motion.h1
                            className="text-6xl md:text-7xl lg:text-8xl font-extrabold mb-6 leading-tight"
                            whileHover={{ scale: 1.05 }}
                            transition={{ type: "spring", stiffness: 300 }}
                        >
                            <span className="block bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 bg-clip-text text-transparent drop-shadow-2xl">
                                Career Fair 2026
                            </span>
                        </motion.h1>

                        <motion.p
                            initial={{ opacity: 0 }}
                            animate={{ opacity: 1 }}
                            transition={{ delay: 0.3, duration: 0.8 }}
                            className="text-2xl md:text-3xl bg-gradient-to-r from-blue-800 via-purple-700 to-cyan-700 dark:from-blue-200 dark:via-purple-300 dark:to-cyan-300 bg-clip-text text-transparent mb-4 font-bold"
                        >
                            Bridging Talent with Opportunity
                        </motion.p>

                        <motion.p
                            initial={{ opacity: 0 }}
                            animate={{ opacity: 1 }}
                            transition={{ delay: 0.5, duration: 0.8 }}
                            className="text-lg md:text-xl text-gray-700 dark:text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed"
                        >
                            Connect with innovative companies, showcase your skills, and launch your tech career faster with our vibrant community.
                        </motion.p>

                        <motion.div
                            initial={{ opacity: 0 }}
                            animate={{ opacity: 1 }}
                            transition={{ delay: 0.7, duration: 0.8 }}
                            className="space-y-4"
                        >
                            <p className="text-2xl md:text-3xl bg-gradient-to-r from-blue-800 via-purple-700 to-cyan-700 dark:from-blue-200 dark:via-purple-300 dark:to-cyan-300 bg-clip-text text-transparent font-bold">
                                Department of Computer Science
                            </p>
                            <p className="text-2xl md:text-3xl bg-gradient-to-r from-blue-800 via-purple-700 to-cyan-700 dark:from-blue-200 dark:via-purple-300 dark:to-cyan-300 bg-clip-text text-transparent font-bold">
                                University of Ruhuna
                            </p>
                        </motion.div>
                    </motion.div>

                    {/* CTA Buttons */}
                    <motion.div
                        initial={{ opacity: 0, y: 30 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ delay: 0.9, duration: 0.8 }}
                        className="flex flex-col sm:flex-row gap-6 justify-center mb-16 mt-12"
                    >
                        {!auth.user ? (
                            <>
                                <Link href="/register">
                                    <motion.button
                                        whileHover={{ scale: 1.1 }}
                                        whileTap={{ scale: 0.95 }}
                                        className="group relative px-10 py-5 bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 text-white rounded-2xl font-bold text-lg overflow-hidden shadow-2xl"
                                    >
                                        <span className="relative z-10 flex items-center justify-center gap-2">
                                            <UserPlusIcon className="w-6 h-6 transition-transform group-hover:rotate-12" />
                                            Join as Student
                                        </span>
                                        <motion.div
                                            className="absolute inset-0 bg-gradient-to-r from-cyan-600 via-blue-600 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                                        />
                                    </motion.button>
                                </Link>

                                <Link href="/register">
                                    <motion.button
                                        whileHover={{ scale: 1.1 }}
                                        whileTap={{ scale: 0.95 }}
                                        className="group relative px-10 py-5 bg-white dark:bg-gray-800 text-gray-900 dark:text-white border-3 border-blue-600 dark:border-purple-400 rounded-2xl font-bold text-lg hover:bg-blue-50 dark:hover:bg-gray-700 shadow-xl overflow-hidden"
                                    >
                                        <span className="relative z-10 flex items-center justify-center gap-2">
                                            <BuildingOfficeIcon className="w-6 h-6 transition-transform group-hover:rotate-12" />
                                            Register Company
                                        </span>
                                        <motion.div className="absolute inset-0 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
                                    </motion.button>
                                </Link>
                            </>
                        ) : (
                            <Link href={auth.user.role === 'admin' ? '/admin/dashboard' : auth.user.role === 'student' ? '/student/dashboard' : '/company/dashboard'}>
                                <motion.button
                                    whileHover={{ scale: 1.05 }}
                                    whileTap={{ scale: 0.95 }}
                                    className="px-10 py-5 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-2xl font-bold text-lg shadow-2xl"
                                >
                                    Go to Dashboard
                                </motion.button>
                            </Link>
                        )}
                    </motion.div>

                    {/* Scroll Indicator */}
                    <motion.div
                        animate={{ y: [0, 10, 0] }}
                        transition={{ duration: 2, repeat: Infinity }}
                        className="relative"
                    >
                        <div className="absolute inset-0 blur-xl bg-gradient-to-r from-blue-500 via-purple-500 to-cyan-500 opacity-50" />
                        <ChevronDownIcon className="w-8 h-8 mx-auto text-blue-600 dark:text-cyan-400 relative z-10" />
                    </motion.div>
                </div>
            </div>
        </section>
    );
}
