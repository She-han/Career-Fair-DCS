import { motion } from 'framer-motion';

const stats = [
    { value: '500+', label: 'Students', delay: 0 },
    { value: '50+', label: 'Companies', delay: 0.2 },
    { value: '1000+', label: 'CVs', delay: 0.4 },
    { value: '98%', label: 'Satisfaction', delay: 0.6 },
];

export default function StatsSection() {
    return (
        <section className="py-20 bg-gradient-to-br from-blue-600 via-purple-600 to-cyan-600 text-white relative overflow-hidden">
            {/* Animated Background Elements */}
            <div className="absolute inset-0 overflow-hidden">
                <motion.div
                    animate={{
                        scale: [1, 1.2, 1],
                        x: [-20, 20, -20],
                    }}
                    transition={{
                        duration: 15,
                        repeat: Infinity,
                        ease: "easeInOut",
                    }}
                    className="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full filter blur-3xl"
                />
                <motion.div
                    animate={{
                        scale: [1, 1.3, 1],
                        x: [20, -20, 20],
                    }}
                    transition={{
                        duration: 20,
                        repeat: Infinity,
                        ease: "easeInOut",
                        delay: 2,
                    }}
                    className="absolute bottom-0 right-0 w-64 h-64 bg-cyan-400/20 rounded-full filter blur-3xl"
                />
            </div>

            <div className="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div className="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    {stats.map((stat, index) => (
                        <motion.div
                            key={stat.label}
                            initial={{ opacity: 0, scale: 0.5 }}
                            whileInView={{ opacity: 1, scale: 1 }}
                            viewport={{ once: true }}
                            transition={{ delay: stat.delay, duration: 0.5 }}
                            whileHover={{ scale: 1.1 }}
                            className="cursor-default"
                        >
                            <motion.div
                                animate={{
                                    scale: [1, 1.05, 1],
                                }}
                                transition={{
                                    duration: 2,
                                    repeat: Infinity,
                                    delay: stat.delay,
                                }}
                                className="text-5xl md:text-6xl font-bold mb-2 drop-shadow-2xl bg-gradient-to-r from-white via-cyan-200 to-white bg-clip-text text-transparent"
                            >
                                {stat.value}
                            </motion.div>
                            <div className="text-xl md:text-2xl opacity-90 font-semibold">
                                {stat.label}
                            </div>
                        </motion.div>
                    ))}
                </div>
            </div>
        </section>
    );
}
