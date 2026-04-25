"use client";

import { useRouter, usePathname, useSearchParams } from "next/navigation";
import { ChevronLeft, ChevronRight } from "lucide-react";
import { clsx } from "clsx";

interface Props {
  currentPage: number;
  lastPage: number;
  total: number;
  from: number;
  to: number;
}

export default function Pagination({ currentPage, lastPage, total, from, to }: Props) {
  const router = useRouter();
  const pathname = usePathname();
  const searchParams = useSearchParams();

  const handlePageChange = (page: number) => {
    if (page < 1 || page > lastPage) return;
    const params = new URLSearchParams(searchParams.toString());
    params.set("page", page.toString());
    router.push(`${pathname}?${params.toString()}`);
  };

  const getPageNumbers = () => {
    const pages = [];
    let start = Math.max(1, currentPage - 2);
    let end = Math.min(lastPage, start + 4);
    
    if (end === lastPage) {
      start = Math.max(1, end - 4);
    }

    for (let i = start; i <= end; i++) {
      pages.push(i);
    }
    return pages;
  };

  return (
    <div className="flex flex-col md:flex-row items-center justify-between gap-4">
      <p className="text-sm text-slate-500 font-medium">
        Showing <span className="text-slate-900 font-bold">{from}–{to}</span> of <span className="text-slate-900 font-bold">{total.toLocaleString()}</span> results
      </p>

      <div className="flex items-center gap-2">
        <button
          onClick={() => handlePageChange(currentPage - 1)}
          disabled={currentPage === 1}
          className="p-2 rounded-xl border border-slate-200 hover:bg-slate-100 disabled:opacity-30 disabled:cursor-not-allowed transition-colors"
        >
          <ChevronLeft className="w-5 h-5" />
        </button>

        <div className="flex items-center gap-1">
          {getPageNumbers().map(num => (
            <button
              key={num}
              onClick={() => handlePageChange(num)}
              className={clsx(
                "w-10 h-10 rounded-xl text-sm font-bold transition-all",
                currentPage === num 
                  ? "bg-blue-600 text-white shadow-lg shadow-blue-200" 
                  : "text-slate-600 hover:bg-slate-100"
              )}
            >
              {num}
            </button>
          ))}
        </div>

        <button
          onClick={() => handlePageChange(currentPage + 1)}
          disabled={currentPage === lastPage}
          className="p-2 rounded-xl border border-slate-200 hover:bg-slate-100 disabled:opacity-30 disabled:cursor-not-allowed transition-colors"
        >
          <ChevronRight className="w-5 h-5" />
        </button>
      </div>
    </div>
  );
}
