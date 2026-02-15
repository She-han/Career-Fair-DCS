import { useState, useEffect, useRef } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/react/24/outline';

const partners = [
    { 
        name: 'Virtusa', 
        industry: 'IT Services & Consulting', 
        logo: 'https://logo.clearbit.com/virtusa.com',
        website: 'virtusa.com'
    },
    { 
        name: 'WSO2', 
        industry: 'Software Development', 
        logo: 'https://logo.clearbit.com/wso2.com',
        website: 'wso2.com'
    },
    { 
        name: 'IFS', 
        industry: 'Enterprise Software', 
        logo: 'https://logo.clearbit.com/ifs.com',
        website: 'ifs.com'
    },
    { 
        name: 'Sysco Labs', 
        industry: 'Technology Solutions', 
        logo: 'https://logo.clearbit.com/syscolabs.com',
        website: 'syscolabs.com'
    },
    { 
        name: '99X', 
        industry: 'Product Engineering', 
        logo: 'https://logo.clearbit.com/99x.io',
        website: '99x.io'
    },
    { 
        name: 'hSenid Software', 
        industry: 'Software Development', 
        logo: 'https://logo.clearbit.com/hsenidsoft.com',
        website: 'hsenidsoft.com'
    },
    { 
        name: 'Millenia Solutions', 
        industry: 'IT Consulting', 
        logo: 'https://logo.clearbit.com/millenia.io',
        website: 'millenia.io'
    },
    { 
        name: 'Zone24x7', 
        industry: 'AI & Data Science', 
        logo: 'https://logo.clearbit.com/zone24x7.com',
        website: 'zone24x7.com'
    },
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
        <section className="py-16 bg-gray-50 dark:bg-gray-900 transition-colors duration-500">
            <div className="container mx-auto px-4 sm:px-6 lg:px-8">
                <div className="flex items-center justify-between mb-8">
                    <motion.div
                        initial={{ opacity: 0, x: -50 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                    >
                        <p className="text-sm font-semibold text-primary-600 dark:text-primary-400 uppercase tracking-wider mb-2">
                            Career Fair 2025 Partners
                        </p>
                        <h3 className="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100">
                            Our Hiring Partners
                        </h3>
                    </motion.div>
                    <div className="flex items-center gap-2">
                        <motion.button
                            whileHover={{ scale: 1.1 }}
                            whileTap={{ scale: 0.9 }}
                            onClick={handlePrev}
                            className="p-3 rounded-full bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 shadow-md hover:shadow-lg transition-all border border-gray-200 dark:border-gray-700"
                        >
                            <ChevronLeftIcon className="w-5 h-5" />
                        </motion.button>
                        <motion.button
                            whileHover={{ scale: 1.1 }}
                            whileTap={{ scale: 0.9 }}
                            onClick={handleNext}
                            className="p-3 rounded-full bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 shadow-md hover:shadow-lg transition-all border border-gray-200 dark:border-gray-700"
                        >
                            <ChevronRightIcon className="w-5 h-5" />
                        </motion.button>
                    </div>
                </div>

                <div ref={trackRef} className="carousel-track flex overflow-x-auto gap-6 pb-4 snap-x snap-mandatory scroll-smooth scrollbar-hide">
                    {partners.map((partner, index) => (
                        <motion.div
                            key={index}
                            initial={{ opacity: 0, y: 50 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true }}
                            transition={{ delay: index * 0.1 }}
                            whileHover={{ scale: 1.03, y: -4 }}
                            className="carousel-slide min-w-[280px] md:min-w-[320px] bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl border border-gray-200 dark:border-gray-700 p-6 flex flex-col items-center text-center gap-4 snap-start transition-all"
                        >
                            <div className="w-20 h-20 rounded-lg bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 flex items-center justify-center p-3 overflow-hidden">
                                <img 
                                    src={partner.logo} 
                                    alt={`${partner.name} logo`}
                                    className="max-w-full max-h-full object-contain"
                                    onError={(e) => {
                                        e.target.style.display = 'none';
                                        e.target.nextSibling.style.display = 'flex';
                                    }}
                                />
                                <div className="hidden w-full h-full items-center justify-center text-2xl font-bold text-primary-600 dark:text-primary-400">
                                    {partner.name.charAt(0)}
                                </div>
                            </div>
                            <div className="flex-1">
                                <h4 className="text-lg font-bold text-gray-900 dark:text-gray-100 mb-1">
                                    {partner.name}
                                </h4>
                                <p className="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                    {partner.industry}
                                </p>
                                <p className="text-xs text-gray-500 dark:text-gray-500">
                                    {partner.website}
                                </p>
                            </div>
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
                            className={`w-2.5 h-2.5 rounded-full transition-all ${
                                index === current
                                    ? 'bg-primary-600 dark:bg-primary-400 scale-125'
                                    : 'bg-gray-300 dark:bg-gray-600'
                            }`}
                        />
                    ))}
                </div>
            </div>
        </section>
    );
}
