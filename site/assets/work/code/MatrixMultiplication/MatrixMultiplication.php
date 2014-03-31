#include &ltpthread.h&gt
#include &ltstdio.h&gt
#include &ltstdlib.h&gt
#define SIZE 384
#define NUM_THREADS 64

int A[SIZE][SIZE];
int B[SIZE][SIZE];
int C[SIZE][SIZE];
int Ar[SIZE][SIZE];
int Br[SIZE][SIZE];
int Cpr[SIZE][SIZE];
int Ac[SIZE][SIZE];
int Bc[SIZE][SIZE];
int Cpc[SIZE][SIZE];
int Ai[SIZE][SIZE];
int Bi[SIZE][SIZE];
int Cpi[SIZE][SIZE];

pthread_mutex_t Cpi_lock[SIZE][SIZE];

void *mult_thread_row(void *threadid)
{
    int tid, i, j, k;
    tid = (int) threadid;

    //  Use Ar, Br, and Cpr in this function
    //starting i = (thread#)*N/T   ending i = (thread#+1)*N/T
    for(i = (tid)*(SIZE/NUM_THREADS); i &lt (tid+1)*(SIZE/NUM_THREADS); i++){
        for(j = 0; j &lt SIZE; j++){
            for(k = 0; k &lt SIZE; k++){
                Cpr[i][j] = Cpr[i][j] + Ar[i][k]*Br[k][j];
            }
        }
    }

}

void *mult_thread_col(void *threadid)
{
    int tid, i, j, k;
    tid = (int) threadid;

    //  Use Ac, Bc, and Cpc in this function\
    //starting j = (thread#)*N/T   ending j = (thread#+1)*N/T
    for(i = 0; i &lt SIZE; i++){
        for(j = (tid)*(SIZE/NUM_THREADS); j &lt (tid+1)*(SIZE/NUM_THREADS); j++){
            for(k = 0; k &lt SIZE; k++){
                Cpc[i][j] = Cpc[i][j] + Ac[i][k]*Bc[k][j];
            }
        }
    }

}

void *mult_thread_inner(void *threadid)
{
    int tid, i, j, k, temp_sum;
    tid = (int) threadid;

    //  Use Ai, Bi, and Cpi in this function
    //starting k = (thread#)*N/T   ending k = (thread#+1)*N/T


    //inner loop parallelization with element Cpi[i][j] locked
    //on each computation
    for(i = 0; i &lt SIZE; i++){
        for(j = 0; j &lt SIZE; j++){
            for(k = (tid)*(SIZE/NUM_THREADS); k &lt (tid+1)*(SIZE/NUM_THREADS); k++){

                pthread_mutex_lock(&Cpi_lock[i][j]);
                Cpi[i][j] = Cpi[i][j] + Ai[i][k]*Bi[k][j];
                pthread_mutex_unlock(&Cpi_lock[i][j]);

            }
        }
    }

    /*
    //inner loop parallelization with local variable 'temp'
    //to aggregate C[i][j] summations
    int temp;
    for(i = 0; i &lt SIZE; i++){
    for(j = 0; j &lt SIZE; j++){

    temp = 0;

    for(k = (tid)*(SIZE/NUM_THREADS); k &lt (tid+1)*(SIZE/NUM_THREADS); k++){

    temp = temp + Ai[i][k]*Bi[k][j];

    }
    pthread_mutex_lock(&Cpi_lock[i][j]);
    Cpi[i][j] = Cpi[i][j] + temp;
    pthread_mutex_unlock(&Cpi_lock[i][j]);

    }
    }
    */

}

int main(int argc, char *argv[])
{

    pthread_t threads[NUM_THREADS];
    pthread_attr_t attr;
    int t, rc, i, j, k, l, ii, jj, kk, ll, count;
    struct timeval start, finish;
    unsigned usec;
    void *status;

    for(i = 0; i &lt SIZE; i++){
        for(j = 0; j &lt SIZE; j++){
            A[i][j] = Ar[i][j] = Ac[i][j] = Ai[i][j] = i*SIZE+j;
            B[i][j] = Br[i][j] = Bc[i][j] = Bi[i][j] = j*SIZE+i;
            C[i][j] = Cpr[i][j] = Cpc[i][j] = Cpi[i][j] = 0;
            pthread_mutex_init(&Cpi_lock[i][j], NULL);
        }
    }

    printf("Performing sequential implementation\n");
    gettimeofday(&start, NULL);
    for(i = 0; i &lt SIZE; i++){
        for(j = 0; j &lt SIZE; j++){
            for(k = 0; k &lt SIZE; k++){
                C[i][j] = C[i][j] + A[i][k]*B[k][j];
            }
        }
    }
    gettimeofday(&finish, NULL);
    usec = finish.tv_sec*1000*1000 + finish.tv_usec;
    usec -= (start.tv_sec*1000*1000 + start.tv_usec);
    printf("Time taken for sequential implementation = %u.\n", usec);


    pthread_attr_init(&attr);
    pthread_attr_setdetachstate(&attr, PTHREAD_CREATE_JOINABLE);

    printf("In main: Creating %d threads for row parallel.\n", NUM_THREADS);
    gettimeofday(&start, NULL);
    for(t = 0; t &lt NUM_THREADS; t++){
        rc = pthread_create(&threads[t], &attr, mult_thread_row, (void*)t);
        if(rc){
            printf("Error: return code from pthread_create is %d.\n", rc);
        }

    }

    //  pthread_exit(NULL);

    for(t = 0; t &lt NUM_THREADS; t++) {
        rc = pthread_join(threads[t], &status);
        if(rc){
            printf("Error from pthread_join().\n");
        }
    }
    gettimeofday(&finish, NULL);
    usec = finish.tv_sec*1000*1000 + finish.tv_usec;
    usec -= (start.tv_sec*1000*1000 + start.tv_usec);
    printf("Time taken with row parallelization = %u.\n", usec);

    // Checking
    count = 0;
    for(i = 0; i &lt SIZE; i++) {
        for(j = 0; j &lt SIZE; j++)	{
            if(C[i][j] != Cpr[i][j]){
                count++;
            }
        }
    }
    printf("Error count = %d.\n", count);

    printf("In main: Creating %d threads for column parallel.\n", NUM_THREADS);
    gettimeofday(&start, NULL);
    for(t = 0; t &lt NUM_THREADS; t++){
        rc = pthread_create(&threads[t], &attr, mult_thread_col, (void*)t);
        if(rc){
            printf("Error: return code from pthread_create is %d.\n", rc);
        }

    }

    for(t = 0; t &lt NUM_THREADS; t++) {
        rc = pthread_join(threads[t], &status);
        if(rc){
            printf("Error from pthread_join().\n");
        }
    }
    gettimeofday(&finish, NULL);
    usec = finish.tv_sec*1000*1000 + finish.tv_usec;
    usec -= (start.tv_sec*1000*1000 + start.tv_usec);
    printf("Time taken with column parallelization = %u.\n", usec);

    // Checking
    count = 0;
    for(i = 0; i &lt SIZE; i++) {
        for(j = 0; j &lt SIZE; j++)	{
            if(C[i][j] != Cpc[i][j]){
                count++;
            }
        }
    }
    printf("Error count = %d.\n", count);

    printf("In main: Creating %d threads for inner loop parallel.\n", NUM_THREADS);
    gettimeofday(&start, NULL);
    for(t = 0; t &lt NUM_THREADS; t++){
        rc = pthread_create(&threads[t], &attr, mult_thread_inner, (void*)t);
        if(rc){
            printf("Error: return code from pthread_create is %d.\n", rc);
        }

    }

    for(t = 0; t &lt NUM_THREADS; t++) {
        rc = pthread_join(threads[t], &status);
        if(rc){
            printf("Error from pthread_join().\n");
        }
    }
    gettimeofday(&finish, NULL);
    usec = finish.tv_sec*1000*1000 + finish.tv_usec;
    usec -= (start.tv_sec*1000*1000 + start.tv_usec);
    printf("Time taken with inner loop parallelization = %u.\n", usec);



    // Checking
    count = 0;
    for(i = 0; i &lt SIZE; i++) {
        for(j = 0; j &lt SIZE; j++)	{
            if(C[i][j] != Cpi[i][j]){
                count++;
                pthread_mutex_destroy(&Cpi_lock[i][j]);
            }
        }
    }
    printf("Error count = %d.\n", count);

}