import { Link, usePage } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { UserPlusIcon, BuildingOfficeIcon, ChevronDownIcon, SignalIcon } from '@heroicons/react/24/outline';
import { useEffect, useRef } from 'react';
import { TypeAnimation } from 'react-type-animation';
import dcsLogo from '@/../../resources/images/dcs.jpg';
import ruhunaLogo from '@/../../resources/images/ruhuna.png';

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
        <section className="relative flex items-center min-h-screen overflow-hidden transition-colors duration-500 bg-gradient-to-br from-gray-900 via-purple-950 to-blue-950 dark:from-gray-900 dark:via-purple-950 dark:to-blue-950">
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
                    className="absolute rounded-full -top-40 -left-40 w-96 h-96 bg-gradient-to-br from-blue-400 via-purple-500 to-cyan-400 mix-blend-multiply filter blur-3xl opacity-20 dark:opacity-20"
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
                    className="absolute rounded-full opacity-20 -bottom-40 -right-40 w-96 h-96 bg-gradient-to-br from-purple-400 via-cyan-500 to-blue-400 mix-blend-multiply filter blur-3xl dark:opacity-20"
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
                    className="absolute transform -translate-x-1/2 -translate-y-1/2 rounded-full opacity-20 top-1/2 left-1/2 w-96 h-96 bg-gradient-to-br from-cyan-400 via-blue-500 to-purple-400 mix-blend-multiply filter blur-3xl dark:opacity-20"
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
                        className="absolute w-2 h-2 rounded-full bg-gradient-to-br from-blue-400 to-purple-500"
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

            <div className="container relative z-10 px-4 py-20 mx-auto sm:px-6 md:mt-12 lg:px-8">
                <div className="max-w-5xl mx-auto text-center">
                    {/* Main Heading */}
                    <motion.div
                        initial={{ opacity: 0, y: 50 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ duration: 0.8 }}
                        className="hero-title"
                    >
                        
                        <motion.div
                            initial={{ opacity: 0 }}
                            animate={{ opacity: 1 }}
                            transition={{ delay: 0.3, duration: 0.8 }}
                            className="mt-6 mb-3 text-2xl font-bold text-transparent md md:text-3xl bg-gradient-to-r from-blue-200 via-purple-300 to-cyan-200 dark:from-blue-200 dark:via-purple-300 dark:to-cyan-300 bg-clip-text"
                        >
                            <TypeAnimation
                                sequence={[
                                    'Bridging Talent with Opportunity',
                                    3000,
                                    'Connecting Students with Leading Tech Companies',
                                    3000,
                                    'Empowering Future Career Journey',
                                    3000,
                                ]}
                                wrapper="span"
                                speed={50}
                                repeat={Infinity}
                            />
                        </motion.div>

                        <motion.h1
                            className="mb-2 text-6xl font-extrabold leading-tight md:text-7xl lg:text-8xl"
                            
                        >
                            <span className="block text-amber-50 bg-clip-text drop-shadow-2xl ">
                                Career Fair '26
                            </span>
                        </motion.h1>


                        <motion.p
                            initial={{ opacity: 0 }}
                            animate={{ opacity: 1 }}
                            transition={{ delay: 0.5, duration: 0.8 }}
                            className="max-w-4xl mx-auto mb-8 font-light leading-relaxed text-gray-300 md:mb-12 text-md md:text-lg dark:text-gray-300"
                        >
                           Meet industry-ready graduates from a top Sri Lankan computer science program at the nation’s premier tech recruitment event.
                        </motion.p>

                        <motion.div
                            initial={{ opacity: 0 }}
                            animate={{ opacity: 1 }}
                            transition={{ delay: 0.7, duration: 0.8 }}
                            className="mt-4 md:mt-8"
                        >
                            {/* University Logos */}
                            <motion.div 
                                initial={{ opacity: 0, scale: 0.8 }}
                                animate={{ opacity: 1, scale: 1 }}
                                transition={{ delay: 0.8, duration: 0.6 }}
                                className="flex items-center justify-center gap-6 mb-6"
                            >
                                {/* DCS Logo */}
                                <motion.div

                                    className="relative group"
                                >
                                    <div className="absolute inset-0 transition-all duration-300 rounded-2xl bg-gradient-to-br from-blue-500/20 via-purple-500/20 to-cyan-500/20 blur-xl group-hover:blur-2xl"></div>
                                    <div className="relative p-2 border shadow-2xl rounded-2xl bg-white/10 dark:bg-white/5 backdrop-blur-xl border-white/20 dark:border-white/10">
                                        <img 
                                            src={dcsLogo} 
                                            alt="DCS Logo" 
                                            className="object-contain w-24 h-24 rounded-xl"
                                        />
                                    </div>
                                </motion.div>

                                {/* Ruhuna Logo */}
                                <motion.div
                                    whileHover={{ scale: 1.1, rotate: -5 }}
                                    className="relative group"
                                >
                                    <div className="absolute inset-0 transition-all duration-300 rounded-2xl bg-gradient-to-br from-purple-500/20 via-blue-500/20 to-cyan-500/20 blur-xl group-hover:blur-2xl"></div>
                                    <div className="relative p-2 border shadow-2xl rounded-2xl bg-white/10 dark:bg-white/5 backdrop-blur-xl border-white/20 dark:border-white/10">
                                        <img 
                                            src={ruhunaLogo} 
                                            alt="University of Ruhuna Logo" 
                                            className="object-contain w-24 h-24 rounded-xl"
                                        />
                                    </div>
                                </motion.div>
                            </motion.div>

                            <p className="text-2xl font-semibold text-gray-100 dark:text-gray-100">
                                Department of Computer Science <br/> University of Ruhuna
                            </p>
                          
                        </motion.div>
                    </motion.div>

                    {/* CTA Buttons */}
                    <motion.div
                        initial={{ opacity: 0, y: 30 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ delay: 0.9, duration: 0.8 }}
                        className="flex flex-col justify-center gap-6 mt-6 mb-8 sm:flex-row"
                    >
                        {!auth.user ? (
                            <>


                                <Link href="#interestform">
                                    <motion.button
                                        whileHover={{ scale: 1.1 }}
                                        whileTap={{ scale: 0.95 }}
                                        className="relative px-6 py-3 overflow-hidden text-lg font-bold text-white bg-transparent border-purple-600 shadow-xl group border-1 dark:border-purple-400 rounded-2xl hover:bg-purple-500 dark:hover:bg-purple-700"
                                    >
                                        <span className="relative z-10 flex items-center justify-center gap-2">
                                            <SignalIcon className="w-6 h-6 transition-transform group-hover:rotate-180" />
                                            Willing to Participate?
                                        </span>
                                        <motion.div className="absolute inset-0 transition-opacity duration-300 opacity-0 bg-gradient-to-r from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30 group-hover:opacity-100" />
                                    </motion.button>
                                </Link>
                            </>
                        ) : (
                            <a href={auth.user.role === 'admin' ? '/admin/dashboard' : auth.user.role === 'student' ? '/student/dashboard' : '/company/dashboard'}>
                                <motion.button
                                    whileHover={{ scale: 1.05 }}
                                    whileTap={{ scale: 0.95 }}
                                    className="px-10 py-5 text-lg font-bold text-white shadow-2xl bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl"
                                >
                                    Go to Dashboard
                                </motion.button>
                            </a>
                        )}
                    </motion.div>

                    {/* Scroll Indicator */}
                    <motion.div
                        animate={{ y: [0, 10, 0] }}
                        transition={{ duration: 2, repeat: Infinity }}
                        className="relative"
                    >
                        <div className="absolute inset-0 opacity-50 blur-xl bg-gradient-to-r from-blue-500 via-purple-500 to-cyan-500" />
                        <ChevronDownIcon className="relative z-10 w-8 h-8 mx-auto text-blue-600 dark:text-cyan-400" />
                    </motion.div>
                </div>
            </div>
        </section>
    );
}
