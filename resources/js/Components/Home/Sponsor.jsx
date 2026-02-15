import React from "react";
import { motion, useAnimation, useScroll, useTransform } from "framer-motion";
import { useInView } from "react-intersection-observer";

import Marquee from "./Marquee";

const Sponsor = () => {
  const controls = useAnimation();
  const [ref, inView] = useInView({ triggerOnce: true, threshold: 0.5 });

  // Scroll position tracking for parallax
  const { scrollYProgress } = useScroll();
  const parallaxY = useTransform(scrollYProgress, [0, 1], ["0%", "-50%"]); // Adjust range for depth

  if (inView) {
    controls.start({ opacity: 1, y: 0 });
  }

  return (
    <motion.div
      
      initial="hidden"
      whileInView={"show"}
      viewport={{ once: false, amount: 0.1 }}
    >
      <div className="relative flex items-center justify-center w-full h-[80vh] pt-16  shadow-none dark:shadow-none shadow-gray-300 dark:text-white dark:bg-gradient-to-b from-gray-900 via-black to-gray-900 rounded-[36px]">
        {/* Parallax Background */}
        <motion.div
          style={{ y: parallaxY }}
          className="absolute top-0 left-0 w-full h-full bg-fixed bg-cover bg-[]"
        ></motion.div>

        {/* Content Section */}
        <div className="relative z-10 flex flex-col items-center max-w-6xl mb-1 space-y-8 text-center">
          <motion.h1
            className="text-6xl font-extrabold text-gray-900 dark:text-white lg:text-8xl"
            initial={{ opacity: 0, scale: 0.5 }}
            animate={{ opacity: 1, scale: 1 }}
            transition={{ duration: 0.5 }}
            viewport={{ once: false, amount: 1 }}
          >
            Hey! Got Interest in <FlipLink href="/">Venture Talks</FlipLink>
          </motion.h1>
          <motion.p
            ref={ref}
            className="text-lg text-gray-700 dark:text-gray-300"
            initial={{ opacity: 0, y: 50 }}
            animate={controls}
            transition={{ duration: 1, delay: 0.5 }}
          >
            Join us as a sponsor and inspire innovation, connect with tech
            leaders, and contribute to the future of the IT industry.
          </motion.p>
          <motion.div
            ref={ref}
            className="inset-0 flex items-center justify-center text-6xl font-bold text-gray-400 pointer-events-none"
            initial={{ opacity: 0, y: 100 }}
            animate={controls}
            transition={{ duration: 1, delay: 1 }}
            viewport={{ once: false, amount: 0.1 }}
          >
            Join Us Now!
          </motion.div>
          <motion.a
            href="/join"
            className="px-8 py-4 text-lg font-bold text-white bg-[#02225f] rounded-full shadow-lg hover:bg-[#fd4101] focus:outline-none focus:ring-4 focus:ring-purple-300"
            whileHover={{ scale: 1.1 }}
            whileTap={{ scale: 0.95 }}
          >
            Become a Sponsor
          </motion.a>
        </div>
      </div>
      <div className="w-full mt-10">
        <Marquee />
      </div>
    </motion.div>
  );
};

export default Sponsor;

const DURATION = 0.25;
const STAGGER = 0.025;

const FlipLink = ({ children, href }) => {
  return (
    <motion.a
      initial="initial"
      whileHover="hovered"
      href={href}
      className="relative block mt-4 overflow-hidden text-4xl font-black whitespace-nowrap sm:text-7xl md:text-8xl lg:text-9xl"
      style={{
        lineHeight: 0.75,
      }}
    >
      <div>
        {children.split("").map((l, i) => (
          <motion.span
            variants={{
              initial: {
                y: 0,
              },
              hovered: {
                y: "-100%",
              },
            }}
            transition={{
              duration: DURATION,
              ease: "easeInOut",
              delay: STAGGER * i,
            }}
            className="inline-block"
            key={i}
          >
            {l}
          </motion.span>
        ))}
      </div>
      <div className="absolute inset-0">
        {children.split("").map((l, i) => (
          <motion.span
            variants={{
              initial: {
                y: "100%",
              },
              hovered: {
                y: 0,
              },
            }}
            transition={{
              duration: DURATION,
              ease: "easeInOut",
              delay: STAGGER * i,
            }}
            className="inline-block"
            key={i}
          >
            {l}
          </motion.span>
        ))}
      </div>
    </motion.a>
  );
};
