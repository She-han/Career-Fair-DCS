import { useState, useEffect, useRef } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/react/24/outline';

const partners = [
    { name: 'TechNova Labs', industry: 'Software', location: 'Colombo, LK', initials: 'TN' },
    { name: 'BlueWave Analytics', industry: 'Data & AI', location: 'Remote', initials: 'BW' },
    { name: 'CyanCloud Systems', industry: 'Cloud', location: 'Singapore', initials: 'CC' },
    { name: 'PurplePeak Solutions', industry: 'FinTech', location: 'London, UK', initials: 'PP' },
    { name: 'NovaHire', industry: 'Talent', location: 'San Francisco, US', initials: 'NH' },
];

export default function PartnersSlider() {
    const [current, setCurrent] = useState(0);
    const [isDark, setIsDark] = useState(false);
    const trackRef = useRef(null);

    useEffect(() => {
        setIsDark(document.documentElement.classList.contains('dark'));

        const observer = new MutationObserver(() => {
            setIsDark(document.documentElement.classList.contains('dark'));
        });
        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

        return () => observer.disconnect();
    }, []);

    useEffect(() => {
        const interval = setInterval(() => {
            setCurrent((prev) => (prev + 1) % partners.length);
        }, 4500);

        return () => clearInterval(interval);
    }, []);

    useEffect(() => {
        if (trackRef.current) {
            const child = trackRef.current.children[current];
            if (child) {
                trackRef.current.scrollTo({ left: child.offsetLeft, behavior: 'smooth' });
            }
        }
    }, [current]);

    const handlePrev = () => {
        setCurrent((prev) => (prev - 1 + partners.length) % partners.length);
    };

    const handleNext = () => {
        setCurrent((prev) => (prev + 1) % partners.length);
    };

    return (
        <section className="py-16 bg-gradient-to-br from-white via-blue-50 to-purple-50 dark:from-gray-900 dark:via-blue-950 dark:to-gray-900 transition-colors duration-500">
            <div className="container mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex items-center justify-between mb-8">
                    <motion.div
                        initial={{ opacity: 0, x: -50 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                    >
                        <p className="text-sm font-semibold text-blue-600 dark:text-cyan-400 uppercase tracking-wider mb-2">
                            Trusted by Leading Companies
                        </p>
                        <h3 className="text-3xl md:text-4xl font-bold bg-gradient-to-r from-purple-700 via-blue-600 to-cyan-700 dark:from-purple-300 dark:via-blue-400 dark:to-cyan-300 bg-clip-text text-transparent">
                            Our Hiring Partners
                        </h3>
                    </motion.div>
                    <div className="flex items-center gap-2">
                        <motion.button
                            whileHover={{ scale: 1.1 }}
                            whileTap={{ scale: 0.9 }}
                            onClick={handlePrev}
                            className="p-3 rounded-full bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900 dark:to-purple-900 text-blue-700 dark:text-blue-200 shadow-lg hover:shadow-xl transition-all"
                        >
                            <ChevronLeftIcon className="w-5 h-5" />
                        </motion.button>
                        <motion.button
                            whileHover={{ scale: 1.1 }}
                            whileTap={{ scale: 0.9 }}
                            onClick={handleNext}
                            className="p-3 rounded-full bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900 dark:to-purple-900 text-blue-700 dark:text-blue-200 shadow-lg hover:shadow-xl transition-all"
                        >
                            <ChevronRightIcon className="w-5 h-5" />
                        </motion.button>
                    </div>
                </div>

                <div ref={trackRef} className="carousel-track flex overflow-x-auto gap-4 pb-4 snap-x snap-mandatory scroll-smooth scrollbar-hide">
                    {partners.map((partner, index) => (
                        <motion.div
                            key={index}
                            initial={{ opacity: 0, y: 50 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true }}
                            transition={{ delay: index * 0.1 }}
                            whileHover={{ scale: 1.05, y: -8 }}
                            className="carousel-slide min-w-[300px] md:min-w-[350px] bg-gradient-to-br from-white via-blue-50 to-purple-50 dark:from-gray-800 dark:via-blue-900/20 dark:to-purple-900/20 rounded-xl shadow-lg border border-blue-100 dark:border-blue-800 p-6 flex items-center justify-between gap-4 snap-start"
                        >
                            <div className="flex-1">
                                <motion.p
                                    whileHover={{ x: 8 }}
                                    className="text-sm text-blue-600 dark:text-cyan-400 font-semibold mb-1"
                                >
                                    {partner.industry}
                                </motion.p>
                                <h4 className="text-xl font-bold text-gray-900 dark:text-gray-100">{partner.name}</h4>
                                <p className="text-sm text-purple-600 dark:text-purple-400 font-medium">{partner.location}</p>
                            </div>
                            <motion.div
                                whileHover={{ rotate: 12, scale: 1.1 }}
                                className="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 via-purple-500 to-cyan-500 text-white flex items-center justify-center text-lg font-bold shadow-lg"
                            >
                                {partner.initials}
                            </motion.div>
                        </motion.div>
                    ))}
                </div>

                {/* Dots Indicator */}
                <div className="flex justify-center gap-2 mt-6">
                    {partners.map((_, index) => (
                        <motion.button
                            key={index}
                            onClick={() => setCurrent(index)}
                            whileHover={{ scale: 1.2 }}
                            whileTap={{ scale: 0.8 }}
                            className={`w-3 h-3 rounded-full transition-all ${
                                index === current
                                    ? 'bg-blue-600 dark:bg-purple-400 scale-125'
                                    : 'bg-gray-300 dark:bg-gray-600'
                            }`}
                        />
                    ))}
                </div>
            </div>
        </section>
    );
}
