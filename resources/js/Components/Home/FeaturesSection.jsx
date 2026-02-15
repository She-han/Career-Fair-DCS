import { motion } from 'framer-motion';
import { BriefcaseIcon, AcademicCapIcon, ShieldCheckIcon } from '@heroicons/react/24/outline';

const features = [
    {
        title: 'Elite Tech Talent Pool',
        description: 'Direct access to 200+ rigorously trained Computer Science students specializing in AI, Software Engineering, Data Science, and Cybersecurity. Our graduates consistently excel in national competitions and hackathons.',
        icon: AcademicCapIcon,
        gradient: 'from-white via-blue-50 to-purple-50 dark:from-gray-900 dark:via-blue-950 dark:to-purple-950',
        bgGradient: 'from-white via-blue-50 to-purple-50 dark:from-gray-900 dark:via-blue-950 dark:to-purple-950',
        border: 'border-blue-200 dark:border-blue-800 hover:border-blue-400 dark:hover:border-blue-600',
    },
    {
        title: 'Smart Recruitment Process',
        description: 'Our exclusive tokenized CV screening system lets you filter candidates by programming languages, frameworks, and experience level. Pre-qualified talent saves you time and resources in the hiring process.',
        icon: BriefcaseIcon,
        gradient: 'from-white via-blue-50 to-purple-50 dark:from-gray-900 dark:via-blue-950 dark:to-purple-950',
        bgGradient: 'from-white via-blue-50 to-purple-50 dark:from-gray-900 dark:via-blue-950 dark:to-purple-950',
        border: 'border-blue-200 dark:border-blue-800 hover:border-blue-400 dark:hover:border-blue-600',
    },
    {
        title: 'Maximum ROI & Convenience',
        description: 'Single-day event with dedicated booth space, on-the-spot interviews, and direct networking. Partner with a prestigious university program trusted by leading tech companies across Sri Lanka.',
        icon: ShieldCheckIcon,
        gradient: 'from-white via-blue-50 to-purple-50 dark:from-gray-900 dark:via-blue-950 dark:to-purple-950',
        bgGradient: 'from-white via-blue-50 to-purple-50 dark:from-gray-900 dark:via-blue-950 dark:to-purple-950',
        border: 'border-blue-200 dark:border-blue-800 hover:border-blue-400 dark:hover:border-blue-600',
    },
];

export default function FeaturesSection() {
    return (
        <section className="py-20 transition-colors duration-500 bg-gray-50 dark:bg-gray-800">
            <div className="container px-4 mx-auto sm:px-6 lg:px-8">
                <motion.div
                    initial={{ opacity: 0, y: -50 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true }}
                    className="mb-16 text-center"
                >
                    <h2 className="mb-4 text-4xl font-bold text-transparent md:text-5xl bg-gradient-to-r from-blue-700 via-purple-600 to-cyan-600 dark:from-blue-300 dark:via-purple-400 dark:to-cyan-400 bg-clip-text drop-shadow-lg">
                        Why Leading Companies Partner With Us
                    </h2>
                    <p className="max-w-2xl mx-auto text-lg text-gray-700 dark:text-gray-300">
                        University of Ruhuna's Computer Science Department: Your gateway to Sri Lanka's brightest tech minds and future industry leaders
                    </p>
                </motion.div>

                <div className="grid grid-cols-1 gap-8 md:grid-cols-3">
                    {features.map((feature, index) => (
                        <motion.div
                            key={feature.title}
                            initial={{ opacity: 0, y: 50 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true }}
                            transition={{ delay: index * 0.1 }}
                            whileHover={{ y: -12, scale: 1.02 }}
                            className={`group relative bg-gradient-to-br ${feature.bgGradient} rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-all duration-500 border-2 ${feature.border} overflow-hidden`}
                        >
                            {/* Background Overlay */}
                            <motion.div
                                initial={{ opacity: 0 }}
                                whileHover={{ opacity: 1 }}
                                className={`absolute inset-0 bg-gradient-to-br ${feature.gradient} opacity-0 group-hover:opacity-10 transition-opacity duration-500`}
                            />

                            {/* Icon */}
                            <motion.div
                                
                                className={`w-16 h-16 bg-gradient-to-br ${feature.gradient} rounded-2xl flex items-center justify-center mb-6 shadow-md shadow-purple-900  relative z-10`}
                            >
                                <feature.icon className="w-8 h-8 text-purple-600" />
                            </motion.div>

                            {/* Content */}
                            <motion.h3
                                whileHover={{ x: 8 }}
                                className="relative z-10 mb-3 text-2xl font-bold text-gray-900 dark:text-gray-100"
                            >
                                {feature.title}
                            </motion.h3>
                            <p className="relative z-10 leading-relaxed text-gray-600 dark:text-gray-400">
                                {feature.description}
                            </p>
                        </motion.div>
                    ))}
                </div>
            </div>
        </section>
    );
}
