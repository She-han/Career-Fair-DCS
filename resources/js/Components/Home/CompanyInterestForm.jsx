import { useForm } from '@inertiajs/react';
import { useState } from 'react';
import { motion } from 'framer-motion';
import { CheckCircleIcon } from '@heroicons/react/24/outline';

const positions = ['Software Engineer', 'QA Engineer', 'AI Engineer', 'Product Manager', 'DevOps Engineer', 'UI/UX Designer', 'Data Scientist', 'Business Analyst', 'Cybersecurity Specialist'];
const languages = ['Java', 'Python', 'C', 'C++', 'C#', 'JavaScript', 'Rust', 'Go', 'PHP', 'Dart', 'TypeScript', 'Kotlin'];
const frameworks = ['Spring Boot', 'React', 'Angular', 'Next.js', 'Django', '.NET', 'Flutter', 'Vue.js', 'Node.js', 'TensorFlow', 'PyTorch', 'Laravel'];

export default function CompanyInterestForm() {
    const { data, setData, post, processing, errors, reset } = useForm({
        company_name: '',
        will_participate: '',
        expected_cvs: '',
        intern_positions: '',
        vacant_positions: [],
        preferred_languages: [],
        preferred_frameworks: [],
        preferred_timeslot: '',
        consent_to_receive_cvs: false,
        message: '',
    });

    const [showConditionalFields, setShowConditionalFields] = useState(false);

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/company-interest', {
            onSuccess: () => reset(),
        });
    };

    const handleParticipationChange = (value) => {
        setData('will_participate', value);
        setShowConditionalFields(value === '1');
    };

    const toggleArrayValue = (array, value) => {
        const currentArray = data[array] || [];
        if (currentArray.includes(value)) {
            setData(array, currentArray.filter(item => item !== value));
        } else {
            setData(array, [...currentArray, value]);
        }
    };

    return (
        <section className="py-20 bg-gradient-to-br from-white via-purple-50 to-cyan-50 dark:from-gray-900 dark:via-purple-950 dark:to-gray-900 transition-colors duration-500">
            <div className="container mx-auto px-4 sm:px-6 lg:px-8">
                <div className="max-w-3xl mx-auto">
                    <motion.div
                        initial={{ opacity: 0, y: -50 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        className="text-center mb-12"
                    >
                        <h2 className="text-4xl md:text-5xl font-bold mb-4 bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 bg-clip-text text-transparent drop-shadow-lg hover:scale-105 transition-transform duration-300">
                            Companies: Join Our Career Fair
                        </h2>
                        <p className="text-lg text-gray-700 dark:text-gray-300 max-w-2xl mx-auto">
                            Interested in participating? Fill out this comprehensive form and we'll get in touch with you!
                        </p>
                    </motion.div>

                    <motion.div
                        initial={{ opacity: 0, y: 50 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        className="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 rounded-2xl shadow-2xl p-8 md:p-10"
                    >
                        <form onSubmit={handleSubmit} className="space-y-6">
                            {/* Company Name */}
                            <div>
                                <label htmlFor="company_name" className="block text-sm font-semibold text-blue-700 dark:text-blue-300 mb-2">
                                    Company Name *
                                </label>
                                <input
                                    type="text"
                                    id="company_name"
                                    value={data.company_name}
                                    onChange={e => setData('company_name', e.target.value)}
                                    className="w-full px-4 py-3 rounded-lg border-2 border-blue-300 dark:border-blue-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-600 transition-all"
                                    placeholder="Enter your company name"
                                    required
                                />
                                {errors.company_name && <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.company_name}</p>}
                            </div>

                            {/* Participation Question */}
                            <div className="border-t-2 border-purple-200 dark:border-purple-800 pt-6">
                                <label className="block text-sm font-semibold text-purple-700 dark:text-purple-300 mb-3">
                                    Will you participate in the Career Fair? *
                                </label>
                                <div className="flex gap-6">
                                    <label className="flex items-center cursor-pointer px-4 py-2 rounded-lg border-2 border-blue-300 dark:border-blue-700 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-all">
                                        <input
                                            type="radio"
                                            name="will_participate"
                                            value="1"
                                            checked={data.will_participate === '1'}
                                            onChange={e => handleParticipationChange(e.target.value)}
                                            className="w-4 h-4 text-blue-600 focus:ring-blue-500"
                                        />
                                        <span className="ml-2 text-gray-800 dark:text-gray-200 font-medium">Yes</span>
                                    </label>
                                    <label className="flex items-center cursor-pointer px-4 py-2 rounded-lg border-2 border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all">
                                        <input
                                            type="radio"
                                            name="will_participate"
                                            value="0"
                                            checked={data.will_participate === '0'}
                                            onChange={e => handleParticipationChange(e.target.value)}
                                            className="w-4 h-4 text-gray-600 focus:ring-gray-500"
                                        />
                                        <span className="ml-2 text-gray-800 dark:text-gray-200 font-medium">No</span>
                                    </label>
                                </div>
                                {errors.will_participate && <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.will_participate}</p>}
                            </div>

                            {/* Conditional Fields */}
                            {showConditionalFields && (
                                <motion.div
                                    initial={{ opacity: 0, height: 0 }}
                                    animate={{ opacity: 1, height: 'auto' }}
                                    exit={{ opacity: 0, height: 0 }}
                                    className="space-y-6 border-t-2 border-cyan-200 dark:border-cyan-800 pt-6"
                                >
                                    {/* CVs and Intern Positions */}
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div className="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-950 dark:to-purple-950 p-4 rounded-xl border border-blue-200 dark:border-blue-800">
                                            <label htmlFor="expected_cvs" className="block text-sm font-semibold text-blue-700 dark:text-blue-300 mb-2">
                                                How many CVs do you hope to receive?
                                            </label>
                                            <input
                                                type="number"
                                                id="expected_cvs"
                                                value={data.expected_cvs}
                                                onChange={e => setData('expected_cvs', e.target.value)}
                                                min="1"
                                                max="500"
                                                className="w-full px-4 py-3 rounded-lg border-2 border-blue-300 dark:border-blue-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 transition-all"
                                                placeholder="50"
                                            />
                                            {errors.expected_cvs && <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.expected_cvs}</p>}
                                        </div>

                                        <div className="bg-gradient-to-br from-purple-50 to-cyan-50 dark:from-purple-950 dark:to-cyan-950 p-4 rounded-xl border border-purple-200 dark:border-purple-800">
                                            <label htmlFor="intern_positions" className="block text-sm font-semibold text-purple-700 dark:text-purple-300 mb-2">
                                                How many intern positions can you provide?
                                            </label>
                                            <input
                                                type="number"
                                                id="intern_positions"
                                                value={data.intern_positions}
                                                onChange={e => setData('intern_positions', e.target.value)}
                                                min="0"
                                                max="100"
                                                className="w-full px-4 py-3 rounded-lg border-2 border-purple-300 dark:border-purple-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 transition-all"
                                                placeholder="5"
                                            />
                                            {errors.intern_positions && <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.intern_positions}</p>}
                                        </div>
                                    </div>

                                    {/* Vacant Positions */}
                                    <div className="bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-cyan-950 dark:to-blue-950 p-6 rounded-xl border-2 border-cyan-200 dark:border-cyan-800">
                                        <label className="block text-sm font-semibold text-cyan-800 dark:text-cyan-200 mb-3">
                                            What positions have vacancies? * <span className="text-xs text-cyan-600 dark:text-cyan-400">(Select all that apply)</span>
                                        </label>
                                        <div className="grid grid-cols-2 md:grid-cols-3 gap-3">
                                            {positions.map((position) => (
                                                <label key={position} className="flex items-center p-3 rounded-lg border-2 border-blue-200 dark:border-blue-800 hover:bg-white dark:hover:bg-gray-900 hover:border-blue-400 dark:hover:border-blue-600 cursor-pointer transition-all bg-white/50 dark:bg-gray-900/50">
                                                    <input
                                                        type="checkbox"
                                                        checked={data.vacant_positions.includes(position)}
                                                        onChange={() => toggleArrayValue('vacant_positions', position)}
                                                        className="w-4 h-4 text-blue-600 focus:ring-blue-500 rounded"
                                                    />
                                                    <span className="ml-2 text-sm font-medium text-gray-800 dark:text-gray-200">{position}</span>
                                                </label>
                                            ))}
                                        </div>
                                        {errors.vacant_positions && <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.vacant_positions}</p>}
                                    </div>

                                    {/* Preferred Languages */}
                                    <div className="bg-gradient-to-br from-purple-50 to-cyan-50 dark:from-purple-950 dark:to-cyan-950 p-6 rounded-xl border-2 border-purple-200 dark:border-purple-800">
                                        <label className="block text-sm font-semibold text-purple-800 dark:text-purple-200 mb-3">
                                            Preferred Programming Languages * <span className="text-xs text-purple-600 dark:text-purple-400">(Select all that apply)</span>
                                        </label>
                                        <div className="grid grid-cols-2 md:grid-cols-4 gap-3">
                                            {languages.map((language) => (
                                                <label key={language} className="flex items-center p-3 rounded-lg border-2 border-purple-200 dark:border-purple-800 hover:bg-white dark:hover:bg-gray-900 hover:border-purple-400 dark:hover:border-purple-600 cursor-pointer transition-all bg-white/50 dark:bg-gray-900/50">
                                                    <input
                                                        type="checkbox"
                                                        checked={data.preferred_languages.includes(language)}
                                                        onChange={() => toggleArrayValue('preferred_languages', language)}
                                                        className="w-4 h-4 text-purple-600 focus:ring-purple-500 rounded"
                                                    />
                                                    <span className="ml-2 text-sm font-medium text-gray-800 dark:text-gray-200">{language}</span>
                                                </label>
                                            ))}
                                        </div>
                                        {errors.preferred_languages && <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.preferred_languages}</p>}
                                    </div>

                                    {/* Preferred Frameworks */}
                                    <div className="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-950 dark:to-purple-950 p-6 rounded-xl border-2 border-blue-200 dark:border-blue-800">
                                        <label className="block text-sm font-semibold text-blue-800 dark:text-blue-200 mb-3">
                                            Preferred Frameworks/Technologies * <span className="text-xs text-blue-600 dark:text-blue-400">(Select all that apply)</span>
                                        </label>
                                        <div className="grid grid-cols-2 md:grid-cols-4 gap-3">
                                            {frameworks.map((framework) => (
                                                <label key={framework} className="flex items-center p-3 rounded-lg border-2 border-cyan-200 dark:border-cyan-800 hover:bg-white dark:hover:bg-gray-900 hover:border-cyan-400 dark:hover:border-cyan-600 cursor-pointer transition-all bg-white/50 dark:bg-gray-900/50">
                                                    <input
                                                        type="checkbox"
                                                        checked={data.preferred_frameworks.includes(framework)}
                                                        onChange={() => toggleArrayValue('preferred_frameworks', framework)}
                                                        className="w-4 h-4 text-cyan-600 focus:ring-cyan-500 rounded"
                                                    />
                                                    <span className="ml-2 text-sm font-medium text-gray-800 dark:text-gray-200">{framework}</span>
                                                </label>
                                            ))}
                                        </div>
                                        {errors.preferred_frameworks && <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.preferred_frameworks}</p>}
                                    </div>

                                    {/* Preferred Timeslot */}
                                    <div className="bg-gradient-to-br from-cyan-50 to-purple-50 dark:from-cyan-950 dark:to-purple-950 p-6 rounded-xl border-2 border-cyan-200 dark:border-cyan-800">
                                        <label htmlFor="preferred_timeslot" className="block text-sm font-semibold text-cyan-800 dark:text-cyan-200 mb-2">
                                            Preferred Time Slot (Career Fair Day - Online) *
                                        </label>
                                        <select
                                            id="preferred_timeslot"
                                            value={data.preferred_timeslot}
                                            onChange={e => setData('preferred_timeslot', e.target.value)}
                                            className="w-full px-4 py-3 rounded-lg border-2 border-cyan-300 dark:border-cyan-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-cyan-500 transition-all"
                                        >
                                            <option value="">Select a time slot</option>
                                            <option value="9:00 AM - 11:00 AM">9:00 AM - 11:00 AM</option>
                                            <option value="11:00 AM - 1:00 PM">11:00 AM - 1:00 PM</option>
                                            <option value="1:00 PM - 3:00 PM">1:00 PM - 3:00 PM</option>
                                            <option value="3:00 PM - 5:00 PM">3:00 PM - 5:00 PM</option>
                                            <option value="5:00 PM - 7:00 PM">5:00 PM - 7:00 PM</option>
                                        </select>
                                        {errors.preferred_timeslot && <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.preferred_timeslot}</p>}
                                    </div>

                                    {/* Consent Checkbox */}
                                    <div className="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-700">
                                        <label className="flex items-start cursor-pointer">
                                            <input
                                                type="checkbox"
                                                checked={data.consent_to_receive_cvs}
                                                onChange={e => setData('consent_to_receive_cvs', e.target.checked)}
                                                className="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 rounded"
                                                required
                                            />
                                            <span className="ml-3 text-sm text-gray-700 dark:text-gray-300">
                                                I consent to receive CVs from the Career Fair portal and understand that student information will be shared with our company for recruitment purposes. *
                                            </span>
                                        </label>
                                        {errors.consent_to_receive_cvs && <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.consent_to_receive_cvs}</p>}
                                    </div>
                                </motion.div>
                            )}

                            {/* Message Field */}
                            <div className="border-t-2 border-blue-200 dark:border-blue-800 pt-6">
                                <label htmlFor="message" className="block text-sm font-semibold text-blue-700 dark:text-blue-300 mb-2">
                                    Additional Message (Optional)
                                </label>
                                <textarea
                                    id="message"
                                    value={data.message}
                                    onChange={e => setData('message', e.target.value)}
                                    rows="4"
                                    className="w-full px-4 py-3 rounded-lg border-2 border-blue-300 dark:border-blue-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 transition-all"
                                    placeholder="Tell us about your requirements..."
                                />
                                {errors.message && <p className="mt-1 text-sm text-red-600 dark:text-red-400">{errors.message}</p>}
                            </div>

                            {/* Submit Button */}
                            <motion.button
                                type="submit"
                                disabled={processing}
                                whileHover={{ scale: 1.05 }}
                                whileTap={{ scale: 0.95 }}
                                className="w-full px-6 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-cyan-600 text-white rounded-xl font-semibold text-lg hover:shadow-2xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                {processing ? 'Submitting...' : 'Submit Interest Form'}
                            </motion.button>

                            <div className="text-center">
                                <p className="text-sm text-gray-600 dark:text-gray-400">
                                    Want to access student CVs directly?{' '}
                                    <a href="/register" className="text-blue-600 dark:text-cyan-400 font-semibold hover:underline transition-colors duration-200">
                                        Register as a company →
                                    </a>
                                </p>
                            </div>
                        </form>
                    </motion.div>
                </div>
            </div>
        </section>
    );
}
